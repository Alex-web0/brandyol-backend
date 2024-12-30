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

class ReviewSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('review')
            ->properties(
                RatingSchema::ref('rating'),
                Schema::integer('likes'),
                Schema::boolean('did_buy'),
                Schema::string('content'),
                Schema::integer('replies')->default(0),

                ...Helper::baseResponseSchema(),
            )->required(
                'rating',
                'likes',
                'did_buy',
                'content'
            );
    }

    public static $ratingRules = 'numeric|max:5.0|min:0.5|required';
}
