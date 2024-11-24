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
        Schema::table('users', function (Blueprint $table) {
            // Money
            $table->decimal('balance', 10, 2)->default(0);
            $table->string('login')->nullable()->unique()->after('email');
            // Data
            $table->foreignId('partner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('phone')->nullable();
            $table->enum('sex', ['male', 'female'])->nullable();
            // Old Security
            $table->integer('referral_link_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['login', 'balance', 'phone', 'sex', 'referral_link_count']);
            $table->dropForeign(['partner_id']);
        });
    }
};
