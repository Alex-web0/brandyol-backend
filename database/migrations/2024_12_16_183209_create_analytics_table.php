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
        Schema::create('analytics', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->integer('total_sales')->default(0);
            $table->double('estimated_revenue')->default(0);
            $table->integer('user_count')->default(0); // Will be populated with User::count()
            $table->integer('transactions_count')->default(0);
            $table->integer('brand_count')->default(0); // Will be populated with Brand::count()
            $table->integer('color_count')->default(0); // Will be populated with ColorScheme::count()
            $table->integer('completed_orders')->default(0);
            $table->integer('pending_orders')->default(0);
            $table->integer('total_products')->default(0); // Will be populated with Product::count()
            $table->timestamps(); // For created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics');
    }
};
