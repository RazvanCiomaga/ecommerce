<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Apple iPhone 13 Pro',
                'description' => 'Apple iPhone 13 Pro',
                'price' => '1000,00', // Changed to string with comma
                'quantity' => 10,
                'in_stock' => true,
                'brand_id' => 1,
                'category_id' => 1,
                'user_id' => 1,
            ],
            [
                'name' => 'Samsung Galaxy S21',
                'description' => 'Samsung Galaxy S21',
                'price' => '1333,28', // Fixed syntax error and used comma for decimal
                'quantity' => 10,
                'in_stock' => true,
                'brand_id' => 2,
                'category_id' => 2,
                'user_id' => 1,
            ],
            [
                'name' => 'Huawei P30 Pro',
                'description' => 'Huawei P30 Pro',
                'price' => '1000,00',
                'quantity' => 10,
                'in_stock' => true,
                'brand_id' => 3,
                'category_id' => 3,
                'user_id' => 1,
            ],
            [
                'name' => 'LG G7 ThinQ',
                'description' => 'LG G7 ThinQ',
                'price' => '1000,00',
                'quantity' => 10,
                'in_stock' => true,
                'brand_id' => 4,
                'category_id' => 4,
                'user_id' => 1,
            ],
            [
                'name' => 'Apple iPhone 13 Pro Max',
                'description' => 'Apple iPhone 13 Pro Max',
                'price' => '1000,00',
                'quantity' => 10,
                'in_stock' => true,
                'brand_id' => 1,
                'category_id' => 5,
                'user_id' => 1,
            ],
            [
                'name' => 'Samsung Galaxy S21 Ultra',
                'description' => 'Samsung Galaxy S21 Ultra',
                'price' => '1000,00',
                'quantity' => 10,
                'in_stock' => true,
                'brand_id' => 2,
                'category_id' => 6,
                'user_id' => 1,
            ],
            [
                'name' => 'Huawei P30 Pro Max',
                'description' => 'Huawei P30 Pro Max',
                'price' => '1000,00',
                'quantity' => 10,
                'in_stock' => true,
                'brand_id' => 3,
                'category_id' => 7,
                'user_id' => 1,
            ],
            [
                'name' => 'LG G7 ThinQ Max',
                'description' => 'LG G7 ThinQ Max',
                'price' => '1000,00',
                'quantity' => 10,
                'in_stock' => true,
                'brand_id' => 4,
                'category_id' => 8,
                'user_id' => 1,
            ],
        ];

        foreach ($products as $product) {
            Product::query()->create($product);
        }
    }
}
