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
        
        $this->input .= $this->inputStart();
        $this->input .= sprintf(" type='text'");

        if (isset($attr['placeholder'])) {
                $this->input .= sprintf(" placeholder='%s'", $attr['placeholder']);
        }

        $this->input .= $this->inputEnd();
        $this->getInput();
    }
}