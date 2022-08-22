<?php

declare(strict_types = 1);

namespace App\Forms\InputTypes;

use App\Forms\InputTypes\InputTypeInterface;
use App\Forms\InputTypes\AbstractInputType;

/**
 * Text type input
 * Available attributes:
 * min, max, label, labelCssClasses, inputCssClasses
 * 
 */
class NumberType extends AbstractInputType implements InputTypeInterface
{

    /**
     * Builds text type html element as string
     * @param array $attr Attributes like placeholder, label, etc.
     */
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
        $this->input .= sprintf(' type="number"');

        $this->input .= sprintf(" name='%s'", $attr['name'] ?? '');
        $this->input .= sprintf(' min="%s"', $attr['min'] ?? '');
        $this->input .= sprintf(' max="%s"', $attr['max'] ?? '');
        $this->input .= sprintf(" class='%s'", $attr['inputCssClasses'] ?? '');

        if (isset($attr['required'])) {
            $this->input .= sprintf(" required=required ");
        }
       

        $this->input .= $this->inputEnd();
        $this->getInput();
    }

    public function getHtmlInputType(): string
    {
        return 'text';
    }
}