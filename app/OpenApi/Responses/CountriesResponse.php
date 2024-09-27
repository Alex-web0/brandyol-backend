<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class CountriesResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response')->content(
            MediaType::json()->schema(
                Schema::object('response')->properties(
                    Schema::array('data')->items(
                        Schema::object('country')->properties(
                            Schema::string('name')->required(),
                            Schema::integer('id')->required(),
                            Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME)->required(),
                            Schema::string('updated_at')->format(Schema::FORMAT_DATE_TIME)->required(),
                        ),

                    )
                )->required('data')
            )->examples(
                Example::create('Default')->value(
                    ['data' => [[
                        'name' => 'العراق',
                        ...config('examples.essentials'),
                        'created_at' => 'العراق',
                    ]]]
                )
            )
        );
    }
}
