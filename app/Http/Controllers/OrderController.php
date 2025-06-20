
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PaymentLog;
use Illuminate\Support\Facades\Auth;

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
            $item->product->increment('stok', $item->quantity);
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

        // Simpan log pembayaran
        PaymentLog::create([
            'order_id' => $order->id,
            'payment_method' => $order->payment_method,
            'amount' => $request->transfer_amount,
            'status' => 'pending_verification',
            'payment_proof' => $filename,
            'account_name' => $request->account_name,
            'bank_name' => $request->bank_name,
            'notes' => $request->notes
        ]);

        $order->update(['payment_status' => 'pending']);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }
}
