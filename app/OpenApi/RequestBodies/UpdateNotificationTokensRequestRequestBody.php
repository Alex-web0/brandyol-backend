<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class UpdateNotificationTokensRequestRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaType::create()->json()->schema(
                Schema::object('body')->properties(
                    Schema::string('token')->required(),
                    Schema::string('device')->enum(['android', 'ios', 'web'])->required(),
                )->required('token', 'device')
            )->examples(
                Example::create('default')->value(
                    [
                        'token' => 'j39y78rn784vbt673t79vb673gf7gf9v3f34f',
                        'device' => 'ios'
                    ]
                )
            )
        );
    }
}
