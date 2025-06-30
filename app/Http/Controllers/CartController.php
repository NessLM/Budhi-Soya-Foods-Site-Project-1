<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cartItems = $user->cart()->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:produk,id_produk',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stok < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi'
            ]);
        }

        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingCart) {
            $existingCart->quantity += $request->quantity;
            $existingCart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'added_at' => now()
            ]);
        }

        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart_count' => $cartCount
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::where('id_cart', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $product = Product::findOrFail($cartItem->product_id);

        if ($product->stok < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi'
            ]);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        $total = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get()
            ->sum(function($item) {
                return $item->quantity * $item->product->harga;
            });

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diperbarui',
            'total' => number_format($total, 0, ',', '.'),
            'item_total' => number_format($cartItem->quantity * $cartItem->product->harga, 0, ',', '.')
        ]);
    }

    public function remove($id)
    {
        $cartItem = Cart::where('id_cart', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItem->delete();

        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        
        $total = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get()
            ->sum(function($item) {
                return $item->quantity * $item->product->harga;
            });

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus dari keranjang',
            'cart_count' => $cartCount,
            'total' => number_format($total, 0, ',', '.')
        ]);
    }

    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan'
        ]);
    }

    public function getCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Cart::where('user_id', Auth::id())->sum('quantity');
        return response()->json(['count' => $count]);
    }
}
