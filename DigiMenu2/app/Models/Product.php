<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Pastikan kolom-kolom ini ada di dalam fillable
    protected $fillable = [
        'name', 'price', 'category', 'image_url', 'is_gluten_free'
    ];
}