<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ErrorDateNotLogged extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::string('message'),


        );

        return Response::create('ErrorDateNotLogged')
            ->description('The date you are looking for was not logged')
            ->content(
                MediaType::json()->schema($response)->examples(
                    Example::create('default')->value(
                        [
                            'message' => 'The data is not found.',
                        ]
                    )
                )
            );
    }
}
