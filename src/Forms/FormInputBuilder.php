<?php

declare(strict_types = 1);

namespace App\Forms;

use App\Forms\FormInputInterface;
use App\Forms\InputTypes\TextType;

/**
 * Creates new input html element
 */
class FormInputBuilder implements FormInputInterface
{
    /**
     * @var array inputs holds all inputs created by chaining
     */
    private $inputs = [];

    /**
     * Adds new input
     * @param string $inputType type of input (TextType, RadioType, etc)
     * @param array $attr attributes of the input
     */
    public function add( string $inputType, array $attr = []): object
    {
        $this->inputs[] = new ($inputType)($attr);
       return $this;

    }
    public function build(): array
    {
        return $this->inputs;
    }

}