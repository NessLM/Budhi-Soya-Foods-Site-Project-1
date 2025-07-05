<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PaymentLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'postal_code' => 'required|string|max:10',
            'provinsi' => 'required|string|max:100',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:produk,id_produk',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            // Calculate total
            $subtotal = 0;
            $orderItems = [];

            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['id']);
                
                // Check stock
                if ($product->jumlah_produk < $productData['quantity']) {
                    throw new \Exception("Stok produk {$product->nama_produk} tidak mencukupi");
                }

                $itemTotal = $product->harga * $productData['quantity'];
                $subtotal += $itemTotal;

                $orderItems[] = [
                    'product_id' => $product->id_produk,
                    'product_name' => $product->nama_produk,
                    'product_price' => $product->harga,
                    'quantity' => $productData['quantity'],
                    'total_price' => $itemTotal
                ];

                // Reduce stock
                $product->decrement('jumlah_produk', $productData['quantity']);
            }

            // Create order
            $order = Order::create([
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
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'product_price' => $item['product_price'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['total_price']
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        $order = Order::with(['orderItems.product', 'paymentLogs'])
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    public function success($id)
    {
        $order = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('orders.success', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $order->update(['status' => 'cancelled']);

        // Kembalikan stok produk
        foreach ($order->orderItems as $item) {
            $item->product->increment('jumlah_produk', $item->quantity);
        }

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan');
    }

    public function confirmPayment(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
            'account_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:100',
            'transfer_amount' => 'required|numeric'
        ]);

        $order = Order::where('user_id', Auth::id())
            ->where('id', $id)
            ->where('payment_status', 'pending')
            ->firstOrFail();

        // Upload bukti pembayaran
        $file = $request->file('payment_proof');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/payments'), $filename);

        // Update order dengan bukti pembayaran
        $order->update([
            'payment_proof' => $filename,
            'payment_status' => 'waiting_verification'
        ]);

        // Simpan log pembayaran
        PaymentLog::create([
            'order_id' => $order->id,
            'payment_method' => $order->payment_method,
            'amount' => $request->transfer_amount,
            'status' => 'pending_verification',
            'notes' => $request->notes ?? 'Bukti pembayaran manual'
        ]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }
}
