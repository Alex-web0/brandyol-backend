<?php

namespace App\OpenApi\Parameters;

use App\Helpers\Helper;
use AppSectionHelper;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class GetAppSectionsParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [

            ...(new PaginationParameters())->build(),


            Parameter::query()
                ->name('name')
                ->description('The name of the resource')
                ->required(false)
                ->schema(Schema::string()),


            Parameter::query()
                ->name('banner_type')
                ->description('The banner_type of the resource')
                ->required(false)
                ->schema(Helper::banner_type()),


            Parameter::query()
                ->name('section')
                ->description('The section of the resource')
                ->required(false)
                ->schema(Helper::section()),


            Parameter::query()
                ->name('type')
                ->description('The type of the resource')
                ->required(false)
                ->schema(Helper::type()),




        ];
    }
}
