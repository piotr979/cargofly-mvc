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
     * @param string $placeholder Placeholder text in the input
     * @param string $inputName input's name for POST action
     * @param string label if not empty label will be added to input
     * @param string $inputCssClasses css classes for input element
     * @param string $labelCssClasses css classes for label
     */
    public function addInput( 
                            string $inputType,
                            array $attr = []
                            )                   
                            ;

    /**
     * Builds inputs (to be used after chaining)
     */
    public function build(): array;
    
}