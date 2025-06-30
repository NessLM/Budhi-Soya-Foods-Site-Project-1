<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('wishlist.index', compact('wishlists'));
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
            'product_id' => 'required|exists:produk,id_produk'
        ]);

        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Produk sudah ada di wishlist'
            ]);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke wishlist'
        ]);
    }

    public function remove($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $wishlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus dari wishlist'
        ]);
    }

    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:produk,id_produk'
        ]);

        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Produk dihapus dari wishlist';
            $action = 'removed';
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ]);
            $message = 'Produk ditambahkan ke wishlist';
            $action = 'added';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'action' => $action
        ]);
    }
}
