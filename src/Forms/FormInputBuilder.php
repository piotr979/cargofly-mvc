<?php

declare(strict_types = 1);

namespace App\Forms;

use App\Forms\FormInputInterface;
use App\Forms\InputTypes\TextType;

class FormInputBuilder implements FormInputInterface
{
    private $inputs = [];

    public function addInput(
                            string $inputType,
                            array $attr = []
    )
    {
        $this->inputs[] = new ($inputType)($attr);
      
    //     if ($label != '') {
    //         $inputLabel = sprintf("<label for='%s'>%s</label>", $inputName, $label);
    //     }
    //    $this->inputs[] = $inputLabel . sprintf("<input type='%s' name='%s' placeholder='%s' class='%s'>", 
    //                     $inputType, 
    //                     $inputName,
    //                     $placeholder,
    //                     $inputCssClasses,
    //                     );

       return $this;

    }
    public function build(): array
    {
        return $this->inputs;
    }

}