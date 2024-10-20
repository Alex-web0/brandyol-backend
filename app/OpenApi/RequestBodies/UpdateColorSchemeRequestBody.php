<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\Schemas\ColorSchemeSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class UpdateColorSchemeRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaType::json()->schema(
                ColorSchemeSchema::ref()
            )->examples(

                Example::create('Default')->value(
                    [
                        'color' => 'FFFFFF',
                        'name' => 'hello',
                        'name_kr' => null,
                    ]
                )

            )
        );
    }
}
