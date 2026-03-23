<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('category_name', 50)->unique();
            // deleted_at is added by: 2024_01_01_000001_add_soft_deletes_to_categories
            // (kept separate so the migration history is preserved)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
