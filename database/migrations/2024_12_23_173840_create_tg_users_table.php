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
        Schema::create('tg_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('tg_id');
            $table->string('phone')->nullable();
            $table->string('name')->nullable();
            $table->text('avatar_url')->nullable();

            $table->text('token')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->json('payload')->nullable();
            $table->boolean('is_banned')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_in_page')->default(false);
            $table->boolean('is_in_stories')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tg_users');
    }
};
