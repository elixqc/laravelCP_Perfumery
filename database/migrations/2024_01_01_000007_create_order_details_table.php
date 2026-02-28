<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // NOTE (3NF): No total/subtotal column here.
        // Subtotal = quantity * unit_price — compute this in the application layer.
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('order_detail_id');
            $table->foreignId('order_id')
                  ->nullable()
                  ->constrained('orders', 'order_id')
                  ->cascadeOnDelete();
            $table->foreignId('product_id')
                  ->nullable()
                  ->constrained('products', 'product_id')
                  ->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            // subtotal (quantity * unit_price) is derived — NOT stored (3NF)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
