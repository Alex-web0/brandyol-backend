<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Example;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class CreateBrandRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {

        $schema = Schema::object('body')->properties(
            Schema::string('name'),
            Schema::string('name_kr')->nullable(),
            Schema::string('description'),
            Schema::string('image')->format('binary')->required(),


        )->required('name', 'description');
        $examples =  Example::create('Default')->value(
            [
                'name' => 'اياكا براند',
                'name_kr' => 'Ayaka Brand',

                'image' => '(BINARY)',

                'description' => 'احد اقوى براندات المكياج',
            ]
        );

        return RequestBody::create()->content(
            MediaType::create()
                ->mediaType('multipart/form-data')
                ->schema(
                    $schema
                )->examples(
                    $examples
                ),
            MediaType::json()
                ->schema(
                    $schema
                )->examples(
                    $examples
                ),
        );
    }
}
