<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class GetProductsParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            ...(new PaginationParameters())->build(),

            Parameter::query()
                ->name('stock')
                ->required(false)
                ->schema(Schema::integer()),

            Parameter::query()
                ->name('price')
                ->required(false)
                ->schema(Schema::number()),

            Parameter::query()
                ->name('cost')
                ->required(false)
                ->schema(Schema::number()),

            Parameter::query()
                ->name('name')
                ->required(false)
                ->schema(Schema::string()),

            Parameter::query()
                ->name('name_kr')
                ->required(false)
                ->schema(Schema::string()),

            Parameter::query()
                ->name('discount')
                ->required(false)
                ->schema(Schema::boolean()),

            Parameter::query()
                ->name('brand_id')
                ->required(false)
                ->schema(Schema::string()),

            Parameter::query()
                ->name('color_scheme_id')
                ->required(false)
                ->schema(Schema::string()),


            Parameter::query()
                ->name('shuffle')
                ->required(false)
                ->schema(Schema::boolean()),

        ];
    }
}
