<?php

declare(strict_types = 1);

namespace App\Forms\InputTypes;

use App\Forms\InputTypes\InputTypeInterface;
use App\Forms\InputTypes\AbstractInputType;

/**
 * Text type input
 * Available attributes:
 * placeholder, label, labelCssClasses, inputCssClasses
 * 
 */
class HiddenType extends AbstractInputType implements InputTypeInterface
{

    /**
     * Builds text type html element as string
     * @param array $attr Attributes like placeholder, label, etc.
     */
    public function __construct(array $attr = [])
    {
        parent::__construct();

       
        $this->input .= $this->inputStart();
        $this->input .= sprintf(' type="hidden"');
        $this->input .= sprintf(' name="%s" value="%s"', $attr['param'], $attr['data'] ?? '');
        $this->input .= $this->inputEnd();
        $this->getInput();
    }
}