<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class UpdateUserRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('updateUser')->content(
            MediaType::create()->json()->schema(
                Schema::object('body')->properties(
                    Schema::string('role')->enum(config('roles')),
                    Schema::string('gender')->enum('male', 'female', 'other'),
                    Schema::string('full_name'),
                )->required('gender', 'role', 'full_name')
            )->examples(
                Example::create('Default')->value(
                    [
                        'role' => 'manager',
                        'full_name' => 'test',
                        'gender' => 'male',
                    ]
                )
            )
        );
    }
}
