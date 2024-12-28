<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class ShadowBanStatusRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('shadow_ban_request')->content(
            MediaType::json()->schema(
                Schema::object('body')->properties(
                    Schema::boolean('shadow_banned')
                )->required('shadow_banned')
            )->examples(
                Example::ref('Default')->value(
                    [
                        'shadow_banned' => true
                    ]
                )
            )
        );
    }
}
