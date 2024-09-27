<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ErrorUnAuthenticatedResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object('response')->properties(
            Schema::string('message')

        );

        return Response::unauthorized()->description('This action is unauthorized.')
            ->content(
                MediaType::json()->schema($response)->examples(
                    Example::create('Default')->value(
                        ['message' => 'Unauthorized.']
                    )
                )
            );
    }
}
