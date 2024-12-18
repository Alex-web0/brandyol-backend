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
                    'data' => []
                ]),
            )
        )
        ;
    }
}
