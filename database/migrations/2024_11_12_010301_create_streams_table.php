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
        Schema::create('streams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->nullable()->constrained('videos')->cascadeOnDelete();
            $table->foreignId('story_id')->nullable()->constrained('stories')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->morphs('streamable');

            $table->string('title');
            $table->string('description')->nullable();
            $table->string('type');
            $table->string('repeat_interval');
            $table->json('payload')->nullable();
            $table->json('options')->nullable();
            $table->json('stats')->nullable();

            $table->boolean('is_active')->default(true);
            $table->boolean('is_online')->default(false);

            $table->string('pid')->nullable();
            $table->string('rtmp_url')->nullable();
            $table->string('rtmp_key')->nullable();

            $table->timestamp('start_at');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('next_at')->nullable();
            $table->integer('play_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streams');
    }
};
