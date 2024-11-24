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
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->integer('max_usage');
            $table->decimal('price', 10, 2);
            $table->boolean('locked')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('promo_code_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promo_code_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_code_user');
        Schema::dropIfExists('promo_codes');
    }
};
