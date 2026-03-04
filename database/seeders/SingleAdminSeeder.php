<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SingleAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@perfumery.com'],
            [
                'username'      => 'admin',
                'full_name'     => 'Site Administrator',
                'email'         => 'admin@perfumery.com',
                'password'      => bcrypt('secret123'),
                'role'          => 'admin',
                'contact_number'=> null,
                'address'       => null,
                'is_active'     => true,
            ]
        );
    }
}
