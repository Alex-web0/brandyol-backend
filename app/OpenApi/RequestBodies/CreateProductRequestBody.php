<?php

namespace App\OpenApi\RequestBodies;

use App\Helpers\Helper;
use App\OpenApi\Schemas\InitialProductImagesSchema;
use App\OpenApi\Schemas\ProductImagesSchema;
use App\OpenApi\Schemas\ProductSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class CreateProductRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaType::create()->mediaType('multipart/form-data')->schema(
                Helper::mergeSchemas(
                    new ProductSchema(),
                    new InitialProductImagesSchema()
                ),
            )->examples(
                Example::create()->value(
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



                        'features' => [
                            ['title' => 'Features 1', 'value' => 'cool product'],

                        ]
                    ]
                ),
            )
        );
    }
}
