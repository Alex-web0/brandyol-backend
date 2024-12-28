<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class CreateReviewParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            // ...(new IDPathParameters())->build(),

            Parameter::query()
                ->name('product_id')
                ->description('Product id of product being reviewed')
                ->required(true)
                ->schema(Schema::integer()),



        ];
    }
}
