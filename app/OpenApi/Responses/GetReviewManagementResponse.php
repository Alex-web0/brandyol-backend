<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\PaginateMetaSchema;
use App\OpenApi\Schemas\ProductImagesSchema;
use App\OpenApi\Schemas\ReviewManagementSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class GetReviewManagementResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->content(
            MediaType::json()->schema(
                Schema::object(
                    'response'
                )->properties(
                    Schema::array('data')->items(
                        ReviewManagementSchema::ref()
                    ),
                    PaginateMetaSchema::ref('meta'),
                ),
            )->examples(
                Example::create()->value([
                    'data' => [
                        [
                            ...config('examples.essentials'),
                            'user' => [],
                            'content' => "This product is awesome",
                            'rating' => 4.5,
                            'did_buy' => true,
                            'likes' => 9,
                            'replies' => 0,
                        ]
                    ],
                    'links' => config('examples.links'),
                    'meta' => config('examples.meta'),
                ]),
            )
        );
    }
}