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
        Schema::create('marketing_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->string('type');
            $table->string('image_url')->nullable();
            $table->date('from_date_joined')->nullable();
            $table->date('to_date_joined')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->integer('from_total_orders')->nullable();
            $table->integer('to_total_orders')->nullable();
            $table->integer('sent')->nullable();
            $table->integer('failed')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_campaigns');
    }
};
