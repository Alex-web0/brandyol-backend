<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ForbiddenResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::string('message'),
            Schema::object('errors')
                ->additionalProperties(
                    Schema::array()->items(Schema::string())
                )
        );

        return Response::create('ForbiddenResponse')
            ->description('you can not access the requested content')
            ->content(
                MediaType::json()->schema($response)->examples(
                    Example::create('default')->value(
                        [
                            'message' => 'You do not have permission to access this.'
                        ]
                    )
                )
            );
    }
}
