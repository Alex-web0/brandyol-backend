<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\PaginateMetaSchema;
use App\OpenApi\Schemas\UserSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class GetAllUsersResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response')->content(
            MediaType::json()->schema(
                Schema::object()->properties(
                    Schema::array('data')->items(
                        UserSchema::ref(),
                    ),
                    PaginateMetaSchema::ref('meta'),
                )
            )->examples(
                Example::create('default')->value(
                    [
                        'data' => [
                            [
                                ...config('examples.essentials'),
                                'full_name' => 'Ali Mohammed',
                                'phone_number' => '+9647781001000',
                                'gender' => 'other',
                                'role' => (config('roles'))[0],
                                'android_token' => 'NULL',
                                'ios_token' => 'NULL',
                                'web_token' => '9dgh2378g96r467rt976b4rt76tb3647xt67fg764cgf76g364gf6g43fv673b876vgf634gf6g4',
                            ]

                        ]
                    ]
                )
            )
        );
    }
}
