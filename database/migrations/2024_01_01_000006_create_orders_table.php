<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users', 'user_id')
                  ->nullOnDelete();
            $table->timestamp('order_date')->useCurrent();
            $table->string('order_status', 20)->default('Pending');
            $table->timestamp('date_received')->nullable();
            $table->text('delivery_address')->nullable();
            $table->string('payment_method', 50)->default('COD');
            $table->string('payment_reference', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
