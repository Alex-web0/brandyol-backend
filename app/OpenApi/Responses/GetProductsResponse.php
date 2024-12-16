<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\PaginateMetaSchema;
use App\OpenApi\Schemas\ProductImagesSchema;
use App\OpenApi\Schemas\ProductSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class GetProductsResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->content(
            MediaType::json()->schema(
                Schema::object(
                    'response'
                )->properties(
                    Schema::array('data')->items(
                        ProductSchema::ref(),
                        ProductImagesSchema::ref(),
                    ),
                    PaginateMetaSchema::ref('meta'),
                ),
            )->examples(
                Example::create()->value([
                    'data' => [
                        [
                            ...config('examples.essentials'),
                            'name' => 'عطر النيش الاصلي',
                            'name_kr' => null,
                            'description' => 'هذا العطر الاصلي الخليجي احد اجود الانواع',

                            'usage' => null,

                            'stock' => 100,
                            'price' => 10.0,
                            'cost' => 5.0,
                            'discount' => 0.60,

                            'color_scheme_id' => 1,
                            'brand_id' => 1,
                            'is_available' => true,
                        ]
                    ],
                    'links' => config('examples.links'),
                    'meta' => config('examples.meta'),
                ]),
            )
        );
    }
}
