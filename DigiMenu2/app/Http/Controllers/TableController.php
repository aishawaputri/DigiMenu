<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        // Mengambil semua meja sekaligus mengecek apakah ada pesanan yang masih 'pending'
        $tables = Table::withCount(['orders' => function ($query) {
            $query->where('status', 'pending'); 
        }])->get();

        // Mengirim data $tables ke view welcome.blade.php
        return view('welcome', compact('tables'));
    }
}