<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\Schemas\RatingSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class CreateReviewRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaType::json()->schema(
                Schema::object('body')->properties(
                    Schema::string('content'),
                    RatingSchema::ref(),
                )->required('content', 'ranting')
            )->examples(
                Example::create('Default')->value(
                    [
                        'content' => 'منتج ممتاز جدا انصح به',
                        'rating' => 4.5,

                    ]
                )

            )
        );
    }
}
