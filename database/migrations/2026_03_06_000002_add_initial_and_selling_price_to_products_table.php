<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('initial_price', 10, 2)->nullable()->after('price');
            $table->decimal('selling_price', 10, 2)->nullable()->after('initial_price');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['initial_price', 'selling_price']);
        });
    }
};
