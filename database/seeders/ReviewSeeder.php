<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::withTrashed()->pluck('product_id')->toArray();
        $customers = User::where('role', 'customer')->pluck('user_id')->toArray();

        if (empty($products) || empty($customers)) {
            $this->command->warn('No products or customers found. Run ProductionDataSeeder first.');

            return;
        }

        $reviewTexts = [
            'Absolutely love this fragrance! Long-lasting and very unique.',
            'Great scent, gets me compliments every time I wear it.',
            'A bit strong for my taste but the quality is undeniable.',
            'Perfect for everyday wear. Light and refreshing.',
            'The bottle design is elegant and the scent is even better.',
            'Good fragrance but fades a bit quickly.',
            'One of my favorites. Very sophisticated and warm.',
            'Smells amazing, will definitely buy again.',
            'Decent scent for the price. Nothing too special.',
            'Very rich and deep. Perfect for evenings out.',
            'Fresh and clean — exactly what I was looking for.',
            'Strong sillage and excellent longevity. Highly recommend.',
            'Not my personal preference but I can see why others love it.',
            'Absolutely stunning. Compliment magnet!',
            'A bit pricey but worth every peso.',
            'Unique scent that stands out from the crowd.',
            'Smooth and creamy, very pleasant on the skin.',
            'Exactly as described. Very happy with my purchase.',
            'The longevity is impressive. Still smelling it 8 hours later.',
            'Nice fragrance but packaging could be improved.',
        ];

        // Track which (product, user) pairs have been reviewed to avoid duplicates
        $reviewed = [];

        foreach ($customers as $userId) {
            // Each customer reviews 1–4 random products
            $count = rand(1, 4);
            $shuffledProducts = $products;
            shuffle($shuffledProducts);
            $toReview = array_slice($shuffledProducts, 0, $count);

            foreach ($toReview as $productId) {
                $key = "{$productId}_{$userId}";
                if (isset($reviewed[$key])) {
                    continue;
                }
                $reviewed[$key] = true;

                $daysAgo = rand(10, 365);
                $reviewedAt = now()->subDays($daysAgo);

                ProductReview::create([
                    'product_id' => $productId,
                    'user_id' => $userId,
                    'rating' => rand(3, 5),
                    'review_text' => $reviewTexts[array_rand($reviewTexts)],
                    'date_reviewed' => $reviewedAt,
                    'last_updated' => $reviewedAt,
                ]);
            }
        }

        $total = count($reviewed);
        $this->command->line("  → {$total} reviews seeded across ".count($customers).' customers');
    }
}
