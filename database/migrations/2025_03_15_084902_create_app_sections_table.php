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


        Schema::create('app_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('banner_type', ['carousel_item', 'banner_16_by_19', 'banner_16_by_7', 'banner_square']);
            $table->enum('section', ['default', 'special_offers', 'brands', 'brandyol_special']);
            $table->enum('type', ['brand', 'product', 'url', ' no_action']);
            $table->integer('brand_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_sections');
    }
};
