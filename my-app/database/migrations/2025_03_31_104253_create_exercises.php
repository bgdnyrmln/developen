<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create categories table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Create exercises table
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('answer');
            $table->timestamps();
        });

        // Create category_exercise pivot table
        Schema::create('category_exercise', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->primary(['category_id', 'exercise_id']); // Composite key for the pivot table
            $table->timestamps(); // Optionally add timestamps for better tracking
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the tables in reverse order
        Schema::dropIfExists('category_exercise');
        Schema::dropIfExists('exercises');
        Schema::dropIfExists('categories');
    }
};
