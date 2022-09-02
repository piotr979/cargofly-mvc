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
class HtmlType extends AbstractInputType implements InputTypeInterface
{

    /**
     * Builds text type html element as string
     * @param array $attr Attributes like placeholder, label, etc.
     */
    public function __construct(array $html)
    {
        parent::__construct();

        $this->input .= sprintf('%s', $html[0]);
        
        $this->getInput();
    }
}