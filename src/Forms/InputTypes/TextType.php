<?php

declare(strict_types = 1);

namespace App\Forms\InputTypes;

use App\Forms\InputTypes\InputTypeInterface;
use App\Forms\InputTypes\AbstractInputType;

class TextType extends AbstractInputType implements InputTypeInterface
{

    public function __construct(array $attr = [])
    {
        parent::__construct();

        if (isset($attr['label'])) {
            $this->input .= $this->addLabel(
                                text: $attr['label'], 
                                labelFor: '',
                                cssClasses: $attr['labelCssClasses'] ?? '');
        }
        $this->input .= $this->inputStart();
        $this->input .= sprintf(" type='text'");

        
        $this->input .= sprintf(" placeholder='%s'", $attr['placeholder'] ?? '');
        $this->input .= sprintf(" class='%s'", $attr['inputCssClasses'] ?? '');

        $this->input .= $this->inputEnd();
        $this->getInput();
    }
}