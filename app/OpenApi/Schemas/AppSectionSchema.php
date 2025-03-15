<?php

namespace App\OpenApi\Schemas;


use App\Helpers\Helper;
use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;


class AppSectionSchema extends SchemaFactory
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('AppSection')
            ->properties(
                Schema::string('name'),
                Helper::banner_type(),
                Helper::section(),
                Helper::type(),

                Schema::integer('brand_id')->nullable(),
                Schema::integer('product_id')->nullable(),
                Schema::string('url')->nullable(),

            )->required(
                'name',
                'banner_type',
                'section',
                'type'
            );
    }
}
