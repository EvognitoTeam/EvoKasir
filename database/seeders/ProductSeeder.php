<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Kopi Latte',
            'category' => 'Minuman',
            'stock' => 50,
            'price' => 25000,
            'image' => 'latte.jpg'
        ]);
    }
}
