<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    public function run(): void
    {
        $products = [
            [
                'name' => 'Smart Phone',
                'description' => 'A smart phone with 4gb ram and much more feature',
                'price' => 999.99,
                'stock' => 50,
                'image' => 'smartphone.jpg',
            ],
            [
                'name' => 'Laptop',
                'description' => 'A laptop with 4gb ram and much more feature',
                'price' => 1499.99,
                'stock' => 30,
                'image' => 'laptop.jpg',
            ],
            [
                'name' => 'Tablet',
                'description' => 'A laptop with 4gb ram and much more feature',
                'price' => 999.99,
                'stock' => 30,
                'image' => 'tablet.jpg',
            ],
            [
                'name' => 'Desktop',
                'description' => 'A desktop with 4gb ram and much more feature',
                'price' => 1499.99,
                'stock' => 30,
                'image' => 'desktop.jpg',
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'A smart watch with 4gb ram and much more feature',
                'price' => 199.99,
                'stock' => 70,
                'image' => 'smartwatch.jpg',
            ],
            [
                'name' => 'Tablet mini',
                'description' => 'A tablet mini with 4gb ram and much more feature',
                'price' => 349.99,
                'stock' => 40,
                'image' => 'tablet.jpg',
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
