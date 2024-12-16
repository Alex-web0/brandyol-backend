<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\PaginateMetaSchema;
use App\OpenApi\Schemas\ProductFeatureSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class GetProductFeaturesResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->content(
            MediaType::json()->schema(
                Schema::object('response')->properties(
                    Schema::array('data')->items(
                        ProductFeatureSchema::ref(),
                    ),
                    PaginateMetaSchema::ref('meta'),

                )
            )->examples(
                Example::create('Default')->value(
                    [
                        'data' => [
                            [
                                ...config('examples.essentials'),
                                'color' => 'FFFFFF',
                                'product_id' => 4,
                                'title' => 'العرض',
                                'value' => 'عرض المنتج ٩٠ سم',

                            ]
                        ],
                        'links' => config('examples.links'),
                        'meta' => config('examples.meta'),
                    ]
                )
            ),
        );
    }
}
