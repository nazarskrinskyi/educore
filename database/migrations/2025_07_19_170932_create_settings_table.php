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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('site_name')->default('Educore');
            $table->text('site_description')->nullable();

            $table->boolean('maintenance_mode')->default(false);

            $table->boolean('certificate_enabled')->default(true);
            $table->string('certificate_issuer_name')->nullable();
            $table->string('certificate_template')->default('default');

            $table->string('telegram_bot_token')->nullable();
            $table->boolean('telegram_reminder_enabled')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
