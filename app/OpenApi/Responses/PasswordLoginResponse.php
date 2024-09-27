<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class PasswordLoginResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response')->content(
            MediaType::json()->schema(
                Schema::object('response')->properties(
                    Schema::string('access_token'),
                    Schema::string('token_type'),
                )->required('access_token', 'token_type')

            )->examples(
                Example::create('Default')->value(
                    [
                        'access_token' => 'token',
                        'token_type' => 'token',
                    ]
                )
            )
        );
    }
}
