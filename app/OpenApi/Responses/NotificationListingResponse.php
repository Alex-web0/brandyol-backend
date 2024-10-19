<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class NotificationListingResponse extends ResponseFactory
{
    public function build(): Response
    {
        return (new PaginateResponse())->build(
            Schema::array('data')->items(
                Schema::object('notification')->properties(

                    Schema::integer('id')->required(),
                    Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME)->required(),
                    Schema::string('updated_at')->format(Schema::FORMAT_DATE_TIME)->required(),
                    Schema::string('title')->required(),
                    Schema::string('body')->nullable(),
                    Schema::string('image_link')->nullable(),
                    Schema::integer('user_id')->required(),
                    Schema::integer('order_id')->nullable(),
                )
            )->required('data'),
            [Example::create('Default')->value(
                [
                    "data" => [
                        [
                            ...config('examples.essentials'),

                        ]
                    ],
                    "links" => config("examples.link"),
                    "meta" => config('examples.meta'),
                ]
            ),]
        );
    }
}
