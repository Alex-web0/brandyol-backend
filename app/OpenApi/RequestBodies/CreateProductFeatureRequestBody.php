<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\Schemas\ProductFeatureSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class CreateProductFeatureRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaType::json()->schema(
                Schema::object('body')->properties(
                    ProductFeatureSchema::ref()->required(
                        'title',
                        'value',
                        'product_id'
                    )

                )
            )->examples(
                Example::create('default')->value(
                    [
                        'title' => 'new color',
                        'value' => 'FFFF66',
                        'product_id' => 2,
                    ]
                )
            )
        );
    }
}
