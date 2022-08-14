<?php

declare(strict_types=1);

namespace App\Forms;

use App\Forms\InputTypes\InputTypeInterface;
use App\Forms\InputTypes\TextType;

/**
 * Input form element creator inteface
 */
interface FormInputInterface
{
    /**
     * Creates HTML input element 
     * @param string $inputType like text,number, etc.
     * @param array $attr Input's attributes
     */

    public function add(string $inputType, array $attr = []): object;

    /**
     * Builds inputs (to be used after chaining)
     */
    public function build(): array;
    
}