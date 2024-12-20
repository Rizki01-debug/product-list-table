<?php
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\ProductController;
use App\Models\Product;

Route::resource('products', ProductController::class);

Route::get('/add-product', function () {
    Product::create([
        'name' => 'Laptop Gaming',
        'description' => 'Laptop dengan spesifikasi tinggi untuk gaming',
        'price' => 15000000,
        'stock' => 10,
    ]);

    return 'Product added successfully!';
});

Route::get('/', function () {
    $products = Product::all();
    return view('products.index', compact('products'));
});

Route::get('/update-product', function () {
    $product = Product::find(1);
    if ($product) {
        $product->update(['stock' => 5]);
        return 'Product updated successfully!';
    }
    return 'Product not found!';
});

Route::get('/delete-product', function () {
    $product = Product::find(1);
    if ($product) {
        $product->delete();
        return 'Product deleted successfully!';
    }
    return 'Product not found!';
});
