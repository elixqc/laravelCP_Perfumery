<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id('review_id');
            $table->foreignId('product_id')
                  ->constrained('products', 'product_id')
                  ->cascadeOnDelete();
            $table->foreignId('user_id')
                  ->constrained('users', 'user_id')
                  ->cascadeOnDelete();
            $table->tinyInteger('rating')->nullable()->comment('1 to 5');
            $table->text('review_text')->nullable();
            $table->timestamp('date_reviewed')->useCurrent();
            $table->timestamp('last_updated')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
