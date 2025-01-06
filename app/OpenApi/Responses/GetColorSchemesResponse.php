<?php

namespace App\OpenApi\Responses;

use App\Helpers\Helper;
use App\OpenApi\Schemas\ColorSchemeResponseSchema;
use App\OpenApi\Schemas\ColorSchemeSchema;
use App\OpenApi\Schemas\EssentialResponseSchema;
use App\OpenApi\Schemas\PaginateMetaSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class GetColorSchemesResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->content(
            MediaType::json()->schema(
                Schema::object(
                    'response'
                )->properties(
                    Schema::array('data')->items(
                        ColorSchemeResponseSchema::ref()
                    ),
                    PaginateMetaSchema::ref('meta'),
                ),
            )->examples(
                Example::create()->value([
                    'data' => [
                        [
                            ...config('examples.essentials'),
                            'name' => 'احمر',
                            'name_kr' => null,
                            'color' => 'FFFFFF',

                        ]
                    ],
                    'links' => config('examples.links'),
                    'meta' => config('examples.meta'),
                ]),
            )
        );
    }
}
