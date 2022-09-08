<?php

declare(strict_types = 1);

namespace App\Forms\FormBuilders;

use App\Forms\FormBuilders\FormBuilderInterface;
use App\Forms\FormBuilders\FormInputBuilder;
use App\Forms\FormBuilders\FormInputInterface;

/**
 * Builds the html form
 * methods to add <form> are formStart and formEnd()
 * anything between are added with follwing methods:
 * ->add() Adds new input
 * ->addHtml() Adds secondary html element like div 
 * 
 * When the form is ready use ->build() and ->getForm()
 */

class FormBuilder implements FormBuilderInterface
{
    private $form;
    private $elements = [];
    private FormInputBuilder $formInputBuilder;

    public function __construct()
    {
        $this->formInputBuilder = new FormInputBuilder();
    }
    public function formStart(string $actionRoute, string $method, string $cssClasses = ''): void
    {
        $this->form .= sprintf("<form class='%s' action='%s' method='%s' enctype='multipart/form-data'>", $cssClasses, $actionRoute, $method);
    }
    public function formEnd(): void
    {
        $this->form .= sprintf("</form>");
    }
    public function add(string $inputType, array $attr = [])
    {
        $element[] = $this->formInputBuilder->add($inputType, $attr);
        return $this;
       
    }

    public function build()
    {
        $this->elements['html'] =  $this->formInputBuilder->build();
        return $this;
    }
    public function getForm(string $actionRoute, string $method = "POST", string $cssClasses = '')
    {
        $this->form .= $this->formStart(actionRoute: $actionRoute, method: $method, cssClasses: $cssClasses);
        foreach ($this->elements['html'] as $html)
        {
            /** 
             * Retrieves html input and adds it to "the middle" of the form 
             */
            $this->form .= $html->getInput();
        }
       
        $this->form .= $this->formEnd();
        return $this->form;
    }
}