<?php

namespace App\OpenApi\RequestBodies;

use App\Helpers\Helper;
use App\OpenApi\Schemas\AppSectionCreationImageSchema;
use App\OpenApi\Schemas\AppSectionSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class CreateAppSectionRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('CreateAppSection')->content(
            MediaType::create()->mediaType('multipart/form-data')->schema(
                Helper::mergeSchemas(
                    'body',
                    new AppSectionSchema(),
                    new AppSectionCreationImageSchema()
                ),
            )->examples(
                Example::create('default')->value(
                    [
                        'name' => 'عنوان البنر',
                        'banner_type' => 'carousel_item',
                        'section' => 'default',
                        'type' => 'brand',
                        'brand_id' => 1


                    ]
                )

            )
        );
    }
}
