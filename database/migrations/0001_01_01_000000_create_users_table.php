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
            $table->string('phone_number', 15)->unique(); // Phone numbers stored in E.164 format (See https://wikipedia.org/wiki/E.164)
            $table->string('full_name');
            $table->enum('role', config('roles'));
            $table->enum('gender', ['male', 'female', 'other']);

            /// notifications
            $table->string('android_token')->nullable();
            $table->string('ios_token')->nullable();
            $table->string('web_token')->nullable();

            /// For staff login
            $table->string('password')->nullable();

            /// For bans
            $table->boolean('banned')->nullable();
            $table->longText('reason')->nullable();

            // For shadow bans
            $table->boolean('shadow_banned')->default(false)->nullable();


            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('phone_number')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
