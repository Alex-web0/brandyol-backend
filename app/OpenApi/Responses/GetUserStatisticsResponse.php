<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\ReviewPublicSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class GetUserStatisticsResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->content(
            MediaType::json()->schema(
                Schema::object(
                    'response'
                )->properties(
                    Schema::object('data')->properties(
                        Schema::number('orders_count'),
                        Schema::number('orders_pending_count'),
                        Schema::number('reviews_count'),
                    ),
                ),
            )->examples(
                Example::create()->value([
                    'data' => [
                        [
                            'orders_count' => 12,
                            'orders_pending_count' => 9,
                            'reviews_count' => 2,
                            // 'last_order' => 2,
                        ]
                    ],
                    // 'links' => config('examples.links'),
                    // 'meta' => config('examples.meta'),
                ]),
            )
        );
    }
}
