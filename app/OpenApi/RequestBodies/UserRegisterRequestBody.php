<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class UserRegisterRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('UserRegister')->content(
            MediaType::json()->schema(
                Schema::create('body')->properties(
                    Schema::string('phone_number')->required(),
                    Schema::string('gender')->enum(['male', 'female', 'other'])->required(),
                    Schema::string('full_name')->required(),
                    Schema::string('otp_method')->enum(['whatsapp', 'sms'])->required(),
                )
            )->examples(
                Example::create('default')->value(
                    [
                        'phone_number' => '+9647731001529',
                        'otp_method' => 'sms',
                        'full_name' => 'hello world',
                        'gender' => 'male',


                    ]
                )

            )
        );
    }
}
