<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('username', 50)->unique();
            $table->string('full_name', 100)->nullable();
            $table->string('contact_number', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('profile_picture', 255)->nullable();
            $table->string('email', 100)->nullable()->unique();
            $table->string('password', 255);
            $table->enum('role', ['admin', 'customer'])->default('customer');
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
