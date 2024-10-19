<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class GetBrandsParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [

            // Parameter::query()
            //     ->name('product_count')
            //     ->description('The count of children products for this')
            //     ->required(false)
            //     ->schema(Schema::integer()),
            Parameter::query()
                ->name('order')
                ->description('The order amount')
                ->required(false)
                ->schema(Schema::string()->enum('desc', 'asc')),
            Parameter::query()
                ->name('per_page')
                ->description('per page')
                ->required(false)
                ->schema(Schema::integer()),
            Parameter::query()
                ->name('name')
                ->description('name of brand')
                ->required(false)
                ->schema(Schema::integer()),
            Parameter::query()
                ->name('from_created_at')
                ->description('When created')
                ->required(false)
                ->schema(Schema::string()->format(Schema::FORMAT_DATE)),
            Parameter::query()
                ->name('to_created_at')
                ->description('When created')
                ->required(false)
                ->schema(Schema::string()->format(Schema::FORMAT_DATE)),

            Parameter::query()
                ->name('shuffle')
                ->description('Weather or not to shuffle the results')
                ->required(false)
                ->schema(Schema::boolean()),

        ];
    }
}
