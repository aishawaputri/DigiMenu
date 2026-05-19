<?php

namespace App\Http\Controllers;

use App\Models\Product; // Pastikan ini ada
use App\Models\Table;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data meja dari URL
        $tableId = $request->query('table');
        $table = null;
        if ($tableId) {
            $table = Table::find($tableId);
        }

        // 2. Ambil SEMUA data menu dari tabel products
        $products = Product::all();

        // 3. Kirim data $table dan $products ke menu.blade.php
        return view('menu', compact('table', 'products'));
    }
}