<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class GetProductFeaturesParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [

            ...(new PaginationParameters())->build(),


            Parameter::query()
                ->name('product_id')
                ->description('the id of the products of which the items will return')
                ->required(false)
                ->schema(Schema::integer()),



        ];
    }
}
