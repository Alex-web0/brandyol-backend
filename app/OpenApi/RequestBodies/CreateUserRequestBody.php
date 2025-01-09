<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class CreateUserRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('CreateUser')->content(
            MediaType::json()->schema(
                Schema::create('body')->properties(
                    Schema::string('phone_number'),
                    Schema::string('role')->enum(config('roles')),
                    Schema::string('gender')->enum('male', 'female', 'other'),
                    Schema::string('full_name'),
                    Schema::string('password'),
                )->required(
                    'phone_number',
                    'role',
                    'gender',
                    'full_name',
                    'password'
                )
            )->examples(
                Example::create('default')->value(
                    [
                        'phone_number' => '+9647731001529',
                        'role' => 'manager',
                        'full_name' => 'hello world',
                        'gender' => 'male',
                        'password' => 'password',


                    ]
                )

            )
        );
    }
}
