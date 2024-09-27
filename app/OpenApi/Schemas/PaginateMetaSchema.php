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

class PaginateMetaSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('PaginateMeta')
            ->properties(
                Schema::integer('current_page'),
                Schema::integer('from')->nullable(),
                Schema::integer('last_page'),
                Schema::integer('per_page'),
                Schema::integer('to')->nullable(),
                Schema::integer('total'),
            )->required(
                'current_page',
                'form',
                'last_page',
                'per_page',
                'to',
                'total'
            );
    }
}
