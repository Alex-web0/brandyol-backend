<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class FileUploadRequestRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaType::create()->mediaType('multipart/form-data')->schema(
                Schema::create('body')->properties(
                    Schema::integer('owner_id'),
                    Schema::integer('owner_type'),
                    Schema::string('attachment')->format('binary')->required(),
                )->required('type', 'image')
            )->examples(
                Example::create(
                    'upload example'
                )->value(
                    [
                        'attachment' => '(BINARY)',
                        'owner_type' => 'product',
                        'owner_id' => 1,
                    ]
                )
            )
        );
    }
}
