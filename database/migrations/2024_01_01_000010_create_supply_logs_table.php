<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // NOTE (3NF): `quantity_remaining` was removed.
        // It is a derived value that can be computed as:
        //   SUM(quantity_added) from supply_logs WHERE product_id = ?
        // Store this logic in a model accessor or query scope instead.
        Schema::create('supply_logs', function (Blueprint $table) {
            $table->id('supply_id');
            $table->foreignId('product_id')
                  ->constrained('products', 'product_id')
                  ->cascadeOnDelete();
            $table->foreignId('supplier_id')
                  ->constrained('suppliers', 'supplier_id')
                  ->cascadeOnDelete();
            $table->integer('quantity_added');
            // quantity_remaining REMOVED — derived from SUM(quantity_added) (3NF)
            $table->decimal('supplier_price', 10, 2)->nullable();
            $table->timestamp('supply_date')->useCurrent();
            $table->text('remarks')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supply_logs');
    }
};
