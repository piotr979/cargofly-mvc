<?php

declare(strict_types = 1);

namespace App\Forms\InputTypes;

use App\Forms\InputTypes\InputTypeInterface;
use App\Forms\InputTypes\AbstractInputType;

/**
 * Text type input
 * Available attributes:
 * min, max, label, labelCssClasses, inputCssClasses
 * Also is 
 * 
 */
class SelectType extends AbstractInputType implements InputTypeInterface
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
        $this->input .= $this->selectStart();
        $this->input .= sprintf(' class="form-select %s"', $attr['selectCssClasses'] ?? '');
        $this->input .= sprintf(' name="%s"', $attr['name'] ?? '');
        $this->input .= '>';
        foreach( $attr['options'] as $value => $option) {
            
                $this->input .= sprintf('<option');
                if ($attr['selectedValue'] === $value ) {
    
                    $this->input .= sprintf(' selected value="%s">%s', $value, $option);
                } else {
                    $this->input .= sprintf(' value="%s">%s', $value, $option);
                }
                $this->input .= sprintf("</option>");
               
        }
        $this->input .= $this->selectEnd();
        $this->getInput();
    }

    public function getHtmlInputType(): string
    {
        return 'text';
    }
}