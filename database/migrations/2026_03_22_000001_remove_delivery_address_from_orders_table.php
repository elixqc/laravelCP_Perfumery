<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Migrate existing delivery_address data to users.address
        DB::statement('
            UPDATE users u
            INNER JOIN orders o ON u.user_id = o.user_id
            SET u.address = o.delivery_address
            WHERE o.delivery_address IS NOT NULL
            AND (u.address IS NULL OR u.address = "")
        ');

        // Drop the delivery_address column
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('delivery_address');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('delivery_address')->nullable();
        });
    }
};
