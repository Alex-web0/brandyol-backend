<?php

namespace App\OpenApi\Schemas;

use App\Helpers\Helper;
use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class AnalyticsSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('Analytics')
            ->properties(
                Schema::number('total_sales'),
                Schema::number('estimated_revenue'),
                Schema::number('user_count'),
                Schema::number('transactions_count'),
                Schema::number('brand_count'),
                Schema::number('color_count'),
                Schema::number('completed_orders'),
                Schema::number('pending_orders'),
                Schema::number('total_products'),

                ...Helper::baseResponseSchema(),
            )->required(
                'total_sales',
                'estimated_revenue',
                'user_count',
                'transactions_count',
                'brand_count',
                'color_count',
                'completed_orders',
                'pending_orders',
                'total_products',
            );
    }
}
