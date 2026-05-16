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
        Schema::create('explore_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location');
            $table->string('country');
            $table->string('category');
            $table->string('duration');
            $table->string('price_from');
            $table->decimal('rating', 2, 1);
            $table->unsignedInteger('hotels');
            $table->string('season')->nullable();
            $table->boolean('featured')->default(false);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('explore_items');
    }
};
