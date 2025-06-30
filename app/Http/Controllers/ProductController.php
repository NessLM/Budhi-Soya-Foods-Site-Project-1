<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function home()
    {
        $products = Product::where('jumlah_produk', '>', 0)
            ->inRandomOrder()
            ->take(3)
            ->get();

    
        return view('home', compact('products'));
    }
    

    
    public function add_index()
{
    return view('admin.addproduct', ['mode' => 'create']);
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'jumlah_produk' => 'required|integer',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $validated['foto'] = $filename;
        }

        Product::create($validated);

        $products = Product::all();
        return view('admin.listproduct', compact('products'));
    }

    public function list_index()
{
    $products = Product::all();
    return view('admin.listproduct', compact('products'));
}

    public function index()
    {
        $products = Product::where('jumlah_produk', '>', 0)->get();
        return view('product', compact('products'));
    }

    public function show($id_produk)
    {
        $product = Product::where('id_produk', $id_produk)->first();
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

public function edit($id_produk)
{
    $product = Product::findOrFail($id_produk);
    return view('admin.addproduct', ['product' => $product, 'mode' => 'edit']);
}




public function update(Request $request, $id_produk)
{
    $product = Product::where('id_produk', $id_produk)->firstOrFail();

    $validated = $request->validate([
        'nama_produk' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'jumlah_produk' => 'required|integer',
        'kategori' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Kalau ada foto baru diupload
    if ($request->hasFile('foto')) {
        // Hapus foto lama kalau ada
        if ($product->foto && file_exists(public_path('uploads/products/' . $product->foto))) {
            unlink(public_path('uploads/products/' . $product->foto));
        }

        $file = $request->file('foto');
        $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/products'), $filename);
        $validated['foto'] = $filename;
    } else {
        // Kalau tidak ada foto baru, biarkan foto lama tetap
        unset($validated['foto']);
    }

    $product->update($validated);

    return redirect()->route('listproduct.index')->with('success', 'Produk berhasil diperbarui.');
}


public function destroy($id_produk)
{
    $product = Product::where('id_produk', $id_produk)->first();

    if (!$product) {
        return redirect()->route('listproduct.index')->with('error', 'Produk tidak ditemukan.');
    }

    // Hapus foto dari folder jika ada
    if ($product->foto && file_exists(public_path('uploads/products/' . $product->foto))) {
        unlink(public_path('uploads/products/' . $product->foto));
    }

    // Hapus data dari database
    $product->delete();

    return redirect()->route('listproduct.index')->with('success', 'Produk berhasil dihapus.');
}


    
}