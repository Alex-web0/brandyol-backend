<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class FileAttachmentParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            ...(new PaginationParameters())->build(),

            Parameter::query()
                ->name('owner_type')
                ->description('The owner type of these file attachments')
                ->required(false)
                ->schema(Schema::string()),

        ];
    }
}
