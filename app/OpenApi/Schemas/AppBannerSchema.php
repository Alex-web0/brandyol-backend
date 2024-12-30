<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class AppBannerSchema extends SchemaFactory
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('AppBanner')
            ->properties(
                // main part of schema
                Schema::string('name'),
                Schema::string('dimensions')->enum(['carousel_item_16_9', 'h_16_7', 'v_1_1', 'contained']),
                Schema::string('type')->enum(['brand', 'product', 'url', 'image'])->default('image'),
                Schema::string('placement')->enum(['general', 'special_offer', 'best_brandyol', 'best_brands'])->default('general'),

                // dependant variables
                Schema::string('url')->nullable(),
                Schema::string('product_id')->nullable(),
                Schema::string('brand_id')->nullable(),
            )->required(
                'name',
                'dimensions',
                'type',
                'placement'
            );
    }
}
