<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\PaginateMetaSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class PaginateResponse extends ResponseFactory implements Reusable
{
    public function build($dataSchema = null, $examples = null): Response
    {
        $response =  Schema::object()->properties(
            $dataSchema ?? Schema::object('data'),
            PaginateMetaSchema::ref('meta')
        )->required('data', 'meta');

        return Response::create('PaginateResponse')->description('Successful response')->content(
            MediaType::json()->schema($response)->examples(
                ...($examples ?? [])
            )
        );
    }
}
