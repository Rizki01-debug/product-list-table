<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);
    
        // Cari nomor urut terakhir
        $lastNumber = Product::max('nomor_urut') ?? 0;
    
        // Tambahkan produk baru
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'nomor_urut' => $lastNumber + 1,
        ]);
    
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }
    
    
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    // Perbarui nomor urut
    $products = Product::orderBy('nomor_urut')->get();
    foreach ($products as $index => $product) {
        $product->update(['nomor_urut' => $index + 1]);
    }

    return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
}

}
