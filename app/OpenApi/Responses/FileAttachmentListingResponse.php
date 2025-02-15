<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\FileAttachmentSchema;
use App\OpenApi\Schemas\PaginateMetaSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class FileAttachmentListingResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response')->content(
            MediaType::json()->schema(
                Schema::object(
                    'response'
                )->properties(
                    Schema::array('data')->items(
                        FileAttachmentSchema::ref()

                    ),
                    PaginateMetaSchema::ref('meta'),
                ),

            )->examples(
                Example::create('Default')->value(
                    [
                        'data' => [],
                        'links' => config('examples.links'),
                        'meta' => config('examples.meta'),
                    ]
                )
            )
        );
    }
}
