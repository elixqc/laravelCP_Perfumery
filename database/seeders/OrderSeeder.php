<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

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
            $orderCount = rand(3, 7);
            for ($i = 0; $i < $orderCount; ++$i) {
                $year = $years[array_rand($years)];
                $month = rand(1, 12);
                $day = rand(1, 28);
                $orderDate = now()
                    ->setDate($year, $month, $day)
                    ->setTime(rand(0, 23), rand(0, 59), rand(0, 59));

                // completed orders get a date_received a few days after order_date
                $daysToReceive = rand(2, 7);
                $dateReceived = (clone $orderDate)->addDays($daysToReceive);

                $order = Order::create([
                    'user_id' => $user->user_id,
                    'order_date' => $orderDate,
                    'order_status' => 'completed',
                    'date_received' => $dateReceived,
                ]);

                // Add 1–4 random products to the order
                $items = $products->random(rand(1, min(4, $products->count())));
                foreach ($items as $product) {
                    OrderDetail::create([
                        'order_id' => $order->order_id,
                        'product_id' => $product->product_id,
                        'quantity' => rand(1, 3),
                    ]);
                }
            }
        }

        $this->command->line('  → orders and order_details seeded with date_received ✅');
    }
}
