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

class UserSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('User')
            ->properties(



                Schema::string('full_name')->required(),
                Schema::string('phone_number')->required(),
                Schema::string('gender')->enum(['male', 'female', 'other'])->required(),
                Schema::string('role')->enum(...[...config('roles')])->required(),
                Schema::string('android_token'),
                Schema::string('ios_token'),
                Schema::string('web_token'),
                Schema::boolean('shadow_banned'),

                ...Helper::baseResponseSchema(),
            );
    }
}
