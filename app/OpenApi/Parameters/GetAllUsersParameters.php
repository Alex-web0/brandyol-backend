<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class GetAllUsersParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [


            ...(new PaginationParameters())->build(),

            Parameter::query()
                ->name('role')
                ->description('The role of the users wanted')
                ->required(false)
                ->schema(Schema::string('role')->enum('staff', ...config('roles'))),

            Parameter::query()
                ->name('phone_number')
                ->description('The phone of the users wanted')
                ->required(false)
                ->schema(Schema::string('phone_number')),

            Parameter::query()
                ->name('gender')
                ->description('The gender of the users wanted')
                ->required(false)
                ->schema(Schema::string('gender')->enum('male', 'female', 'other')),

            Parameter::query()
                ->name('full_name')
                ->description('The full_name of the users wanted')
                ->required(false)
                ->schema(Schema::string('full_name')),

            Parameter::query()
                ->name('id')
                ->description('The id of the users')
                ->required(false)
                ->schema(Schema::number('id')),

            Parameter::query()
                ->name('orders_more_than')
                ->description('The sales per capita')
                ->required(false)
                ->schema(Schema::number()),
            Parameter::query()
                ->name('orders_less_than')
                ->description('The sales per capita')
                ->required(false)
                ->schema(Schema::number()),

        ];
    }
}
