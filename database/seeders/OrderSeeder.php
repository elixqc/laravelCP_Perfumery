<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Get all non-admin users
        $users = User::where('role', '!=', 'admin')->get();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        // Years to spread orders across
        $years = [2022, 2023, 2024, 2025, 2026];

        foreach ($users as $user) {
            $orderCount = rand(3, 7); // More orders for better spread
            for ($i = 0; $i < $orderCount; $i++) {
                // Pick a random year and random month/day
                $year = $years[array_rand($years)];
                $month = rand(1, 12);
                $day = rand(1, 28); // Safe for all months
                $orderDate = now()->setDate($year, $month, $day)->setTime(rand(0,23), rand(0,59), rand(0,59));

                $order = Order::create([
                    'user_id' => $user->user_id,
                    'order_date' => $orderDate,
                    'order_status' => 'completed',
                ]);

                // Add 1-4 random products to the order
                $items = $products->random(rand(1, min(4, $products->count())));
                foreach ($items as $product) {
                    $qty = rand(1, 3);
                    OrderDetail::create([
                        'order_id' => $order->order_id,
                        'product_id' => $product->product_id,
                        'quantity' => $qty,
                    ]);
                }
            }
        }
    }
}