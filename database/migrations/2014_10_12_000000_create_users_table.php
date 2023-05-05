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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('token_key');
            $table->string('refresh_token_key');
            $table->string('expires_at');
            $table->boolean('active');
            $table->string('login_token');
            $table->string('password_reset_token');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
