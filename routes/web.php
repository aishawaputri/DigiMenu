<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use App\Models\Table; // <-- Tambahan PENTING agar model Table dikenali

// Route Halaman Utama (Pilih Meja / Tipe Pesanan)
Route::get('/', function () {
    $tables = Table::all(); // Ambil semua data meja dari database
    return view('welcome', compact('tables')); // Kirim variabel $tables ke halaman welcome
});

// Route Halaman Menu
Route::get('/menu', function () {
    $products = Product::all(); 
    return view('menu', compact('products'));
});

// Route Halaman Payment
Route::get('/payment', function () {
    return view('payment');
});

// ROUTE INI YANG MEMPROSES CHECKOUT
Route::post('/process-checkout', [OrderController::class, 'store']);