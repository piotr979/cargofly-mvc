<?php

declare(strict_types = 1);

namespace App\Forms\InputTypes;

use App\Forms\InputTypes\InputTypeInterface;
use App\Forms\InputTypes\AbstractInputType;

class TextType extends AbstractInputType implements InputTypeInterface
{

    public function __construct(string $text, array $params = [])
    {
        $this->input = sprintf("<input type='text'>");
    }
}