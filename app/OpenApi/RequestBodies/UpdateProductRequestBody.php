<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\Schemas\ProductSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class UpdateProductRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaType::create()->json()->schema(
                ProductSchema::ref()->required(
                    'name',
                    'description',
                    'stock',
                    'price',
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
                    ]
                ),
            )
        );
    }
}
