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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            /// TODO: MAKE UNIFIED WITH OTHER MIGRATIONS
            $table->string('name');
            $table->string('name_kr')->nullable();

            /// further details
            $table->longText('description'); // might be markdown
            $table->longText('usage')->nullable(); // might be markdown

            // ------> Item FEATURES are a relationship

            // stock & pricing
            $table->bigInteger('stock');
            $table->double('cost');
            $table->double('price');
            $table->double('discount')->nullable(); // from 0.00 to 0.99

            // card image (has one 1:1 card image)
            $table->foreignId('file_attachment_id');


            /// colors
            $table->foreignId('color_scheme_id');
            // brand
            $table->foreignId('brand_id');


            ///  CONTROL & AVAILABILITY
            $table->boolean('is_available');


            // User who created product (for future use)
            $table->foreignId('user_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
