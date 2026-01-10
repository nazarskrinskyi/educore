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
        Schema::create('page_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('page_name')->unique(); // 'home', 'dashboard', etc.
            $table->string('section_key')->index(); // 'hero', 'platforms', 'about', etc.
            $table->json('content'); // Flexible JSON content for each section
            $table->integer('order')->default(0); // Display order
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['page_name', 'section_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_configurations');
    }
};
