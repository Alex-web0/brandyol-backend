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
                    "links" => [
                        "first" => "http://localhost:30000/api/v1/drivers/popular?page=1",
                        "last" => "http://localhost:30000/api/v1/drivers/popular?page=1",
                        "prev" => null,
                        "next" => null
                    ],
                    "meta" => [
                        "current_page" => 1,
                        "from" => 1,
                        "last_page" => 1,
                        "links" => [
                            [
                                "url" => null,
                                "label" => "&laquo; Previous",
                                "active" => false
                            ],
                            [
                                "url" => "http://localhost:30000/api/v1/drivers/popular?page=1",
                                "label" => "1",
                                "active" => true
                            ],
                            [
                                "url" => null,
                                "label" => "Next &raquo;",
                                "active" => false
                            ]
                        ],
                        "path" => "http://localhost:30000/api/v1/drivers/popular",
                        "per_page" => 15,
                        "to" => 1,
                        "total" => 1
                    ]
                ]
            ),]
        );
    }
}
