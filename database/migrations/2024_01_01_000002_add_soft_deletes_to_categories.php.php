<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// RENAMED from: 2024_01_01_000001_add_soft_deletes_to_categories.php
// REASON: The old filename shared the same timestamp prefix as
//         2024_01_01_000001_create_categories_table.php.
//         Laravel sorts alphabetically, so "add_" ran before "create_",
//         causing a "table doesn't exist" error on migrate:fresh.
//         Bumping the suffix to 000002 guarantees it runs after the table is created.

return new class extends Migration {
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
