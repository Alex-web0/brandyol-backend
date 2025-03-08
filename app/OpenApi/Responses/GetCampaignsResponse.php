<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\PaginateMetaSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class GetCampaignsResponse extends ResponseFactory
{
    public function build(): Response
    {
        return (new PaginateResponse())->build(
            Schema::array('data')->items(
                Schema::object()->properties(



                    Schema::integer('id')->required(),
                    Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME)->required(),
                    Schema::string('updated_at')->format(Schema::FORMAT_DATE_TIME)->required(),

                    Schema::string('title'),
                    Schema::string('body')->nullable(),
                    Schema::string('type')->enum('notification', 'whatsapp'),
                    Schema::string('gender')->enum('male', 'female', 'other')->nullable(),
                    Schema::string('image_url')->nullable(),



                    PaginateMetaSchema::ref('meta'),

                )->required('id', 'created_at', 'title', 'type')
            ),
            [
                Example::create('Default')->value(
                    [
                        'data' => [
                            [
                                ...config('examples.essentials'),

                                'title' => "OwO",
                                'body' => "Hello there",
                                'type' => "notification",
                                'gender' => "NULL",
                                'image_url' => "NULL",
                            ]
                        ],
                        'meta' => config('examples.meta'),
                        'links' => config('examples.links'),
                    ]
                ),
            ],
        );
    }
}
