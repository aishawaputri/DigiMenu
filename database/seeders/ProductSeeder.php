<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema; // Pastikan baris ini ditambahkan

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Matikan pengecekan relasi (foreign key) sementara
        Schema::disableForeignKeyConstraints();
        
        // Kosongkan tabel
        Product::truncate();
        
        // Hidupkan kembali pengecekan relasi
        Schema::enableForeignKeyConstraints();

        $menus = [
            [
                'name' => 'Chicken Wings',
                'price' => 35000,
                'category' => 'Snack',
                'image_url' => 'https://images.unsplash.com/photo-1527477396000-e27163b481c2?w=300&q=80',
                'is_spicy' => true,
                'is_gluten_free' => false
            ],
            [
                'name' => 'Beef Burger Deluxe',
                'price' => 55000,
                'category' => 'Main Course',
                'image_url' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=300&q=80',
                'is_spicy' => false,
                'is_gluten_free' => false
            ],
            [
                'name' => 'French Fries',
                'price' => 25000,
                'category' => 'Snack',
                'image_url' => 'https://images.unsplash.com/photo-1576107232684-1279f390859f?w=300&q=80',
                'is_spicy' => false,
                'is_gluten_free' => true
            ],
            [
                'name' => 'Caesar Salad',
                'price' => 40000,
                'category' => 'Appetizer',
                'image_url' => 'https://images.unsplash.com/photo-1550304943-4f24f54ddde9?w=300&q=80',
                'is_spicy' => false,
                'is_gluten_free' => true
            ],
            [
                'name' => 'Spaghetti Bolognese',
                'price' => 45000,
                'category' => 'Main Course',
                'image_url' => 'https://images.unsplash.com/photo-1622973536968-3ead9e780960?w=300&q=80',
                'is_spicy' => false,
                'is_gluten_free' => false
            ],
            [
                'name' => 'Ice Lemon Tea',
                'price' => 15000,
                'category' => 'Beverage',
                'image_url' => 'https://images.unsplash.com/photo-1499638673689-79a0b5115d87?w=300&q=80',
                'is_spicy' => false,
                'is_gluten_free' => true
            ],
            [
                'name' => 'Coca Cola',
                'price' => 12000,
                'category' => 'Beverage',
                'image_url' => 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=300&q=80',
                'is_spicy' => false,
                'is_gluten_free' => true
            ],
        ];

        foreach ($menus as $menu) {
            Product::create($menu);
        }
    }
}