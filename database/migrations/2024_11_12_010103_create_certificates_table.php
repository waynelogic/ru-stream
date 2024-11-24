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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->index();
            $table->longText('content')->nullable();
            $table->boolean('active')->default(true);
            $table->decimal('needed_points', 10, 2);
            $table->longText('promo_codes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('certificate_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->boolean('is_used')->default(false);
            $table->text('options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_user');
        Schema::dropIfExists('certificates');
    }
};
