<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['category_name' => 'Men\'s Fragrances'],
            ['category_name' => 'Women\'s Fragrances'],
            ['category_name' => 'Unisex Fragrances'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create suppliers
        $suppliers = [
            ['supplier_name' => 'Luxury Scents Inc.', 'is_active' => true],
            ['supplier_name' => 'Aroma Distributors', 'is_active' => true],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // Create products
        $products = [
            [
                'product_name' => 'Eau de Parfum Classic',
                'description' => 'A timeless classic fragrance.',
                'price' => 89.99,
                'stock_quantity' => 50,
                'variant' => '100ml',
                'is_active' => true,
                'category_id' => 1,
                'supplier_id' => 1,
            ],
            [
                'product_name' => 'Floral Essence',
                'description' => 'Fresh floral notes for everyday wear.',
                'price' => 65.00,
                'stock_quantity' => 30,
                'variant' => '75ml',
                'is_active' => true,
                'category_id' => 2,
                'supplier_id' => 2,
            ],
            [
                'product_name' => 'Citrus Breeze',
                'description' => 'Refreshing citrus scent for all.',
                'price' => 55.00,
                'stock_quantity' => 40,
                'variant' => '50ml',
                'is_active' => true,
                'category_id' => 3,
                'supplier_id' => 1,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
