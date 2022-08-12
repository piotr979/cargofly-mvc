<?php

declare(strict_types = 1);
namespace App\Forms;

class FormBuilder
{
    public function addInput(
                            string $inputType, 
                            string $placeholder, 
                            string $cssClasses,
                            string $label = '',
                            string $inputName)
    {
        if ($label != '') {
            $label = sprintf('<label for={$inputName}>{$label}</label>');
        }
        return $label . sprintf("<input 
                        type='{$inputType}' 
                        placeholder='{$placeholder}'
                        class='{$cssClasses}'
                        name='{$inputName}
                        ");
    }
}