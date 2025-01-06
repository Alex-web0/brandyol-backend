<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\PaginateMetaSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class GetBrandsResponse extends ResponseFactory
{
    public function build(): Response
    {
        return (new PaginateResponse())->build(
            Schema::array('data')->items(
                Schema::object()->properties(

                    Schema::integer('id')->required(),
                    Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME)->required(),
                    Schema::string('updated_at')->format(Schema::FORMAT_DATE_TIME)->required(),

                    Schema::string('name'),
                    Schema::string('name_kr')->nullable(),
                    Schema::string('description'),
                    Schema::string('image'),
                    Schema::number('products_count'),

                    PaginateMetaSchema::ref('meta'),

                )->required('id', 'created_at', 'name', 'description', 'image', 'products_count')
            ),
            [
                Example::create('Default')->value(
                    [
                        'data' => [
                            [
                                ...config('examples.essentials'),

                                'name' => 'اياكا براند',
                                'name_kr' => 'Ayaka Brand',
                                'image' => 'https://link.com',

                                'description' => 'احد اقوى براندات المكياج',
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
