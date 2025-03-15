<?php

namespace App\OpenApi\Responses;

use App\Helpers\Helper;
use App\OpenApi\Schemas\AppSectionImageSchema;
use App\OpenApi\Schemas\AppSectionSchema;
use App\OpenApi\Schemas\DefaultResponseSchema;
use App\OpenApi\Schemas\PaginateMetaSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class GetAppSectionsResponse extends ResponseFactory
{
    public function build(): Response
    {
        return (new PaginateResponse())->build(
            Schema::array('data')->items(
                Helper::mergeSchemas(
                    'item',
                    new DefaultResponseSchema(),
                    new AppSectionSchema(),
                    new AppSectionImageSchema(),
                )
            ),
            [
                Example::create('Default')->value(
                    [
                        'data' => [
                            [
                                ...config('examples.essentials'),

                                'name' => 'عنوان البنر',
                                'banner_type' => 'carousel_item',
                                'section' => 'default',
                                'type' => 'brand',
                                'brand_id' => 1,
                                'url' => 'NULL',

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
