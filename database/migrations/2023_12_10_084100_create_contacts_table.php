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
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreignId('phone_code_id')->nullable()->constrained('phones')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('phone_number', 20)->unique();

            $table->string('email')->nullable()->unique();
            $table->string('whatsapp', 20)->nullable()->unique();
            $table->string('instagram')->nullable()->unique();
            $table->string('facebook')->nullable();

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
