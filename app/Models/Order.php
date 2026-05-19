<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Sesuaikan fillable dengan kolom yang ada di phpMyAdmin kamu
    protected $fillable = [
        'table_id', 
        'guest_count', 
        'total_amount', 
        'status'
    ];

    public function table() {
        return $this->belongsTo(Table::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}