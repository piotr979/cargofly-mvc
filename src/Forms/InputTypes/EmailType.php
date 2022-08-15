<?php

declare(strict_types = 1);

namespace App\Forms\InputTypes;

use App\Forms\InputTypes\TextType;


class EmailType extends TextType
{
    public function getHtmlInputType(): string
    {
        return 'email';
    }
}