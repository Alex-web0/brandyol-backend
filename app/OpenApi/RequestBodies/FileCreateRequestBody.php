<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class FileCreateRequestBody extends RequestBodyFactory implements Reusable
{
    public function build(): RequestBody
    {
        return RequestBody::create('file_create_request')->content(
            MediaType::create()->mediaType('multipart/form-data')->schema(
                Schema::object('body')->properties(
                    Schema::string('file')->format('binary')->required(),
                    Schema::integer('owner_id')->required(),
                    Schema::string('owner_type')->required(),
                )->required('file', 'owner_id', 'owner_type')
            )->examples(
                Example::create('Default')->value(
                    [
                        'file' => 'Your File',
                        'owner_id' => 1,
                        'owner_type' => 'Products',
                    ]
                )
            )
        );
    }
}
