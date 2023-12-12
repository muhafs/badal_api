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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();

            $table->enum('gender', ['M', 'F'])->default('M');
            $table->date('birth_date');

            $table->text('image_porfile')->nullable();
            $table->enum('type', ['ADM', 'PRF', 'SKR'])->default('SKR'); // Performer - Seeker

            $table->foreignId('address')->nullable()->constrained('addresses')->nullOnDelete();
            $table->foreignId('nationality')->nullable()->constrained('countries')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
