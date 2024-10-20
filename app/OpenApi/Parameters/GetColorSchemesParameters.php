<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class GetColorSchemesParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            ...(new PaginationParameters())->build(),
            Parameter::query()
                ->name('color')
                ->description('Hex string color value')
                ->required(false)
                ->schema(Schema::string()),

            Parameter::query()
                ->name('name')
                ->description('name string color ')
                ->required(false)
                ->schema(Schema::string()),


        ];
    }
}
