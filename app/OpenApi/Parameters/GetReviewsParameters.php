<?php

namespace App\OpenApi\Parameters;

use App\OpenApi\Schemas\RatingSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class GetReviewsParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [

            ...(new PaginationParameters())->build(),


            Parameter::query()
                ->name('did_buy')
                ->description('If users bought or not')
                ->required(false)
                ->schema(Schema::boolean()),

            Parameter::query()
                ->name('product_id')
                ->description('The id of the product reviews')
                ->required(false)
                ->schema(Schema::integer()),

            Parameter::query()
                ->name('user_id')
                ->description('The id of the product reviews')
                ->required(false)
                ->schema(Schema::integer()),

            Parameter::query()
                ->name('rating')
                ->description('Rating double')
                ->required(false)
                ->schema(RatingSchema::ref()),

            Parameter::query()
                ->name('most_likes')
                ->description('By likes')
                ->required(false)
                ->schema(Schema::boolean()),

        ];
    }
}
