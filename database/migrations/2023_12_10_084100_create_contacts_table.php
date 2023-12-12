<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();

            $table->string('email')->nullable()->unique();
            $table->string('phone_number', 20)->unique();

            $table->string('whatsapp')->nullable()->unique();
            $table->string('instagram')->nullable()->unique();
            $table->string('facebook')->nullable()->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
