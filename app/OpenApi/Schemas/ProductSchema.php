<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class ProductSchema extends SchemaFactory implements Reusable
{

    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('Product')
            ->properties(
                Schema::string('name'),
                Schema::string('name_kr')->nullable(),
                Schema::string('description'),

                Schema::string('usage')->nullable(),

                Schema::integer('stock'),
                Schema::number('discount')->nullable(),
                Schema::number('price'),
                Schema::number('cost'),

                Schema::number('color_scheme_id'),
                Schema::number('brand_id'),
                Schema::boolean('is_available'),

                Schema::array('features')->items(
                    ProductFeatureSchema::ref()
                ),

                Schema::string('image')->format('binary')->required(),

            )->required(
                'name',
                'description',
                'stock',
                'price',
                'brand_id',
                'color_scheme_id',
                'image',

            );
    }
}
