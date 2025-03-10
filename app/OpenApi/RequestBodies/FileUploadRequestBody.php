<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class FileUploadRequestBody extends RequestBodyFactory implements Reusable
{
    public function build(): RequestBody
    {
        return RequestBody::create('file_upload_request')->content(
            MediaType::create()->mediaType('multipart/form-data')->schema(
                Schema::object('body')->properties(
                    Schema::string('file')->format('binary')->required(),
                    /// will override the file being saved to this particular path MODEL instead of going for an id
                    Schema::string('path_override')->nullable(),
                )->required('file')
            )->examples(
                Example::create('Default')->value(
                    [
                        'file' => 'Your File'
                    ]
                )
            )
        );
    }
}
