<?php

namespace App\OpenApi\Schemas;

use App\Helpers\Helper;
use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class ReviewManagementSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        $reviewSchema = (new ReviewSchema())->build();

        return Schema::object('ReviewManagement')
            ->properties(
                UserSchema::ref('user'),
                ProductSchema::ref('product'),
                ...$reviewSchema->properties,
            )->required(
                'user',
                'product',
                ...$reviewSchema->required
            );
    }
}
