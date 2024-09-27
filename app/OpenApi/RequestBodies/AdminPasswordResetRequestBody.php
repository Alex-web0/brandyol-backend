<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class AdminPasswordResetRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaType::create()->json()->schema(
                Schema::object('body')->properties(
                    Schema::string('new_password')->required(),
                    Schema::integer('user_to_reset')->required(),
                )
            )->examples(
                Example::create('Default')->value(
                    [
                        'new_password' => 'password',
                        'user_to_reset' => 1,
                    ]
                )

            )
        );
    }
}
