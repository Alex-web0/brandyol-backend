<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ApiHealthResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response')->content(
            MediaType::json()->schema(
                Schema::object('response')->properties(
                    Schema::object('data')->properties(
                        Schema::string('version')
                    )->required('version')
                )->required('data')

            )->examples(

                Example::create('Default')->value(
                    ['data' => ['version' => '1.0.0']]
                )
            )
        );
    }
}
