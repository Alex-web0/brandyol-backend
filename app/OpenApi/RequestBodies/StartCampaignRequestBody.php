<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class StartCampaignRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('StartCampaign')->content(
            MediaType::json()->schema(
                Schema::object('body')->properties(
                    Schema::string('from_date_joined')->format(Schema::FORMAT_DATE)->nullable(),
                    Schema::string('to_date_joined')->format(Schema::FORMAT_DATE)->nullable(),
                    Schema::string('title'),
                    Schema::string('body')->nullable(),
                    Schema::string('type')->enum(['notification', 'whatsapp']),
                )->required(
                    'title',
                    'type'
                )
            )->examples(
                Example::create('Notification')->value([
                    'from_date_joined' => '2023-10-10',
                    'to_date_joined' => '2023-10-10',
                    'type' => 'notification',
                    'body' => null,
                    'title' => 'We released a new product!!',
                ]),
                Example::create('Whatsapp')->value([
                    'from_date_joined' => '2023-10-10',
                    'to_date_joined' => '2023-10-10',
                    'type' => 'whatsapp',
                    'body' => 'We will give you a discount if you buy it now!!!',
                    'title' => 'We released a new product!!',
                ]),
            )
        );
    }
}
