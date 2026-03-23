<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Run after a fresh migration:
     *   php artisan migrate:fresh --seed
     *
     * Or seed only:
     *   php artisan db:seed
     */
    /**
     * Order matters:
     *   1. ProductionDataSeeder — restores real categories, suppliers, users,
     *                             products, product_images (paths preserved), supply_logs
     *   2. OrderSeeder          — randomly generates orders + order_details
     *                             based on the real users & products above
     *   3. ReviewSeeder         — randomly generates product reviews
     *                             based on the real users & products above
     */
    public function run(): void
    {
        $this->call([
            ProductionDataSeeder::class,
            OrderSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
