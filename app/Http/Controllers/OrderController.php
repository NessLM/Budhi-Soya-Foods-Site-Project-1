<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PaymentLog;
use App\Models\AuditLogAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class OrderController extends Controller
{
    /**
     * Display a listing of user orders
     */
    public function index()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Create a new order
     */
    public function create(Request $request)
    {
        Log::info('Order creation request received', [
            'user_id' => Auth::id(),
            'request_data' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        try {
            $request->validate([
                'nama_pemesan' => 'required|string|max:255',
                'alamat_lengkap' => 'required|string',
                'postal_code' => 'required|string|max:10',
                'provinsi' => 'required|string|max:100',
                'products' => 'required|array|min:1',
                'products.*.id' => 'required|exists:produk,id_produk',
                'products.*.quantity' => 'required|integer|min:1'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . implode(', ', array_flatten($e->errors()))
            ], 422);
        }

        try {
            // Test database connection first
            DB::connection()->getPdo();
            
            // Test if tables exist
            $tables = ['orders', 'order_items', 'produk'];
            foreach ($tables as $table) {
                if (!Schema::hasTable($table)) {
                    throw new \Exception("Table {$table} does not exist");
                }
            }
            
            DB::beginTransaction();

            $orderData = $this->prepareOrderData($request);
            $order = $this->createOrder($orderData);
            $this->createOrderItems($order, $request->products);
            $this->logOrderCreation($order);

            DB::commit();

            Log::info('Order created successfully', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Order creation failed', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified order
     */
    public function show($id)
    {
        $order = Order::with(['orderItems.product', 'paymentLogs'])
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order
     */
    public function cancel($id)
    {
        try {
            DB::beginTransaction();

            $order = Order::where('user_id', Auth::id())
                ->where('id', $id)
                ->whereIn('status', ['pending', 'processing'])
                ->firstOrFail();

            $this->cancelOrder($order);
            $this->logOrderCancellation($order);

            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil dibatalkan');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Order cancellation failed', [
                'order_id' => $id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->route('orders.index')
                ->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Confirm payment for an order
     */
    public function confirmPayment(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
            'account_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:100',
            'transfer_amount' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            $order = Order::where('user_id', Auth::id())
                ->where('id', $id)
                ->where('payment_status', 'pending')
                ->firstOrFail();

            $filename = $this->uploadPaymentProof($request->file('payment_proof'));
            $this->updateOrderPayment($order, $filename, $request);
            $this->createPaymentLog($order, $request);

            DB::commit();

            Log::info('Payment proof uploaded', [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'filename' => $filename
            ]);

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Payment confirmation failed', [
                'order_id' => $id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->route('orders.show', $id)
                ->with('error', 'Gagal mengirim bukti pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Prepare order data from request
     */
    private function prepareOrderData(Request $request): array
    {
        $subtotal = $this->calculateSubtotal($request->products);

        return [
            'user_id' => Auth::id(),
            'order_number' => Order::generateOrderNumber(),
            'status' => 'pending',
            'subtotal' => $subtotal,
            'tax_amount' => 0,
            'shipping_cost' => 0,
            'total_amount' => $subtotal,
            'payment_status' => 'pending',
            'payment_method' => 'manual_transfer',
            'shipping_name' => $request->nama_pemesan,
            'shipping_phone' => Auth::user()->phone ?? '',
            'shipping_address' => $request->alamat_lengkap,
            'shipping_city' => '',
            'shipping_province' => $request->provinsi,
            'shipping_postal_code' => $request->postal_code,
            'notes' => 'Pesanan manual dari website'
        ];
    }

    /**
     * Calculate order subtotal
     */
    private function calculateSubtotal(array $products): float
    {
        $subtotal = 0;

        foreach ($products as $productData) {
            try {
                $product = Product::findOrFail($productData['id']);
                
                if ($product->jumlah_produk < $productData['quantity']) {
                    throw new \Exception("Stok produk {$product->nama_produk} tidak mencukupi");
                }

                $subtotal += $product->harga * $productData['quantity'];
            } catch (\Exception $e) {
                Log::error('Product calculation error', [
                    'product_id' => $productData['id'],
                    'error' => $e->getMessage()
                ]);
                throw $e;
            }
        }

        return $subtotal;
    }

    /**
     * Create order record
     */
    private function createOrder(array $orderData): Order
    {
        return Order::create($orderData);
    }

    /**
     * Create order items and update stock
     */
    private function createOrderItems(Order $order, array $products): void
    {
        foreach ($products as $productData) {
            try {
                $product = Product::findOrFail($productData['id']);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id_produk,
                    'product_name' => $product->nama_produk,
                    'product_price' => $product->harga,
                    'quantity' => $productData['quantity'],
                    'total_price' => $product->harga * $productData['quantity']
                ]);

                // Reduce stock
                $product->decrement('jumlah_produk', $productData['quantity']);
                
                Log::info('Order item created', [
                    'order_id' => $order->id,
                    'product_id' => $product->id_produk,
                    'quantity' => $productData['quantity']
                ]);
            } catch (\Exception $e) {
                Log::error('Order item creation error', [
                    'product_id' => $productData['id'],
                    'error' => $e->getMessage()
                ]);
                throw $e;
            }
        }
    }

    /**
     * Cancel order and restore stock
     */
    private function cancelOrder(Order $order): void
    {
        $order->update(['status' => 'cancelled']);

        // Restore stock
        foreach ($order->orderItems as $item) {
            if ($item->product) {
                $item->product->increment('jumlah_produk', $item->quantity);
            }
        }
    }

    /**
     * Upload payment proof file
     */
    private function uploadPaymentProof($file): string
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/payments'), $filename);
        return $filename;
    }

    /**
     * Update order payment status
     */
    private function updateOrderPayment(Order $order, string $filename, Request $request): void
    {
        $order->update([
            'payment_proof' => $filename,
            'payment_status' => 'waiting_verification'
        ]);
    }

    /**
     * Create payment log entry
     */
    private function createPaymentLog(Order $order, Request $request): void
    {
        PaymentLog::create([
            'order_id' => $order->id,
            'payment_method' => $order->payment_method,
            'amount' => $request->transfer_amount,
            'status' => 'pending_verification',
            'notes' => $request->notes ?? 'Bukti pembayaran manual'
        ]);
    }

    /**
     * Log order creation
     */
    private function logOrderCreation(Order $order): void
    {
        AuditLogAdmin::create([
            'admin_id' => null,
            'user_id' => Auth::id(),
            'action' => 'order_created',
            'description' => "Order {$order->order_number} created",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    /**
     * Log order cancellation
     */
    private function logOrderCancellation(Order $order): void
    {
        AuditLogAdmin::create([
            'admin_id' => null,
            'user_id' => Auth::id(),
            'action' => 'order_cancelled',
            'description' => "Order {$order->order_number} cancelled",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    /**
     * Delete order from user view (soft delete)
     */
    public function delete($id)
    {
        try {
            $order = Order::where('user_id', Auth::id())
                ->where('id', $id)
                ->where('status', 'cancelled')
                ->firstOrFail();

            // Log the deletion
            AuditLogAdmin::create([
                'admin_id' => null,
                'user_id' => Auth::id(),
                'action' => 'order_deleted_from_view',
                'description' => "Order {$order->order_number} removed from user view",
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);

            // For now, just log the deletion without soft delete
            // TODO: Add is_hidden_from_user column to database later
            Log::info('Order marked for deletion', [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'order_number' => $order->order_number
            ]);

            return redirect()->route('orders.index')
                ->with('success', 'Pesanan telah dihapus dari tampilan. Data tetap tersimpan di log.');

        } catch (\Exception $e) {
            Log::error('Order deletion failed', [
                'order_id' => $id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->route('orders.index')
                ->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }
}
