<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class DefaultResponseSchema extends SchemaFactory
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('DefaultResponse')
            ->properties(
                Schema::integer('id')->required(),
                Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME)->required(),
                Schema::string('updated_at')->format(Schema::FORMAT_DATE_TIME)->required(),
            )->required('id', 'created_at');
    }
}
