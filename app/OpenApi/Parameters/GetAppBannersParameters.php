<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class GetAppBannersParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            ...(new PaginationParameters())->build(),


            Parameter::query()
                ->name('parameter-name')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::string()),

        ];
    }
}
