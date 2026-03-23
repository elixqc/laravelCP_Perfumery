<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name', 100);
            $table->text('description')->nullable();
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories', 'category_id')
                  ->nullOnDelete();
            $table->foreignId('supplier_id')
                  ->nullable()
                  ->constrained('suppliers', 'supplier_id')
                  ->nullOnDelete();
            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->string('image_path', 255)->nullable();
            $table->string('variant', 50)->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
