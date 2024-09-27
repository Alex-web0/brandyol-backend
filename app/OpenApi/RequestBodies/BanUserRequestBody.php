<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class BanUserRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('LiftBanRequest')->content(
            MediaType::create()->json()->schema(
                Schema::object('body')->properties(
                    Schema::string('reason')->nullable()
                )
            )->examples(
                Example::create('Default')->value([
                    'reason' => 'I do not like you',
                ])
            )
        );
    }
}
