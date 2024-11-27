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
        Schema::create('vk_groups', function (Blueprint $table) {
            $table->id();
            $table->string('vk_id');
            $table->string('name');
            $table->text('avatar_url')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('vk_user_id')->constrained('vk_users')->cascadeOnDelete();
            $table->boolean('in_dashboard')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vk_groups');
    }
};
