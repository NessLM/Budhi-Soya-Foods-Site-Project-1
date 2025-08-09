<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }

        $addresses = UserAddress::where('user_id', Auth::id())->get();
        $defaultAddress = $addresses->where('is_default', true)->first();

        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->harga;
        });

        $taxAmount = $subtotal * 0.11; // PPN 11%
        $shippingCost = 15000; // Biaya pengiriman tetap
        $total = $subtotal + $taxAmount + $shippingCost;

        return view('checkout.index', compact('cartItems', 'addresses', 'defaultAddress', 'subtotal', 'taxAmount', 'shippingCost', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_province' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:bank_transfer,cash_on_delivery,ewallet',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
            }

            // Hitung total
            $subtotal = $cartItems->sum(function($item) {
                return $item->quantity * $item->product->harga;
            });

            $taxAmount = $subtotal * 0.11;
            $shippingCost = 15000;
            $totalAmount = $subtotal + $taxAmount + $shippingCost;

            // Buat order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_cost' => $shippingCost,
                'total_amount' => $totalAmount,
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_province' => $request->shipping_province,
                'shipping_postal_code' => $request->shipping_postal_code,
            ]);

            // Buat order items dan update stok
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;

                if ($product->jumlah_produk < $cartItem->quantity) {
                    throw new \Exception("Stok produk {$product->nama_produk} tidak mencukupi");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id_produk,
                    'product_name' => $product->nama_produk,
                    'product_price' => $product->harga,
                    'quantity' => $cartItem->quantity,
                    'total_price' => $cartItem->quantity * $product->harga,
                ]);

                // Update stok produk
                $product->decrement('jumlah_produk', $cartItem->quantity);
            }

            // Hapus cart items
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('order.success', $order->id)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
} 