<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class PasswordLoginRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('PasswordLogin')->content(
            MediaType::create()->json()->schema(
                Schema::create('body')->properties(
                    Schema::string('phone_number')->required(),
                    Schema::string('password')->required(),
                )
            )->examples(
                Example::create('Default')->value(
                    [
                        'phone_number' => '+9647731001529',
                        'password' => 'password',
                    ]
                )
            )
        );
    }
}
