<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class GetAnalyticsParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [

            Parameter::query()
                ->name('start_date')
                ->description('Start date of analytics')
                ->required(false)
                ->schema(Schema::string()->format(Schema::FORMAT_DATE)),

            Parameter::query()
                ->name('end_date')
                ->description('End date of analytics')
                ->required(false)
                ->schema(Schema::string()->format(Schema::FORMAT_DATE)),

        ];
    }
}
