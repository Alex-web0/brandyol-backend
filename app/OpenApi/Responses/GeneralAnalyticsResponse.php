<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\AnalyticsSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class GeneralAnalyticsResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->content(
            MediaType::json()->schema(
                Schema::object(
                    'response'
                )->properties(
                    AnalyticsSchema::ref('data')
                ),
            )->examples(
                Example::create()->value([
                    'data' => [
                        "id" => 1,
                        "total_sales" => 0,
                        "estimated_revenue" => 0,
                        "user_count" => 3,
                        "transactions_count" => 0,
                        "brand_count" => 1,
                        "color_count" => 2,
                        "completed_orders" => 0,
                        "pending_orders" => 0,
                        "total_products" => 2,
                        "created_at" => "2024-12-27T15:06:41.000000Z",
                        "updated_at" => "2024-12-27T15:06:41.000000Z"
                    ]
                ]),
            )
        )
        ;
    }
}
