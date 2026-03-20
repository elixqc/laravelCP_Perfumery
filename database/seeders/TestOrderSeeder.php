<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get a test customer
        $customer = \App\Models\User::updateOrCreate(
            ['email' => 'customer@test.com'],
            [
                'username'      => 'testcustomer',
                'full_name'     => 'Test Customer',
                'password'      => bcrypt('password'),
                'role'          => 'customer',
                'is_active'     => true,
            ]
        );

        // Get some products from the database
        $products = \App\Models\Product::take(3)->get();

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Please run ProductSeeder first.');
            return;
        }

        // Create a test order
        $order = \App\Models\Order::create([
            'user_id'       => $customer->user_id,
            'order_date'    => now(),
            'order_status'  => 'completed',
        ]);

        // Add order details (line items) for each product
        foreach ($products as $product) {
            $quantity = rand(1, 3);
            $unitPrice = $product->price;
            \App\Models\OrderDetail::create([
                'order_id'      => $order->order_id,
                'product_id'    => $product->product_id,
                'quantity'      => $quantity,
            ]);
        }

        $this->command->info('Test order created successfully!');
        $this->command->info("Order ID: {$order->order_id}, Total: \${$totalAmount}");
    }
}
