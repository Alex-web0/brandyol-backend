<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\Schemas\ProductFeatureSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class UpdateProductFeatureRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaType::json()->schema(
                ProductFeatureSchema::ref('body')->required(
                    'title',
                    'value',
                )
            )->examples(
                Example::create('default')->value(
                    [
                        'title' => 'updated color',
                        'value' => 'FFFF66'
                    ]
                )
            )
        );
    }
}
