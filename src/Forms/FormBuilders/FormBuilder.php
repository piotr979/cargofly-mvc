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

    public function __construct($action)
    {
        $this->formInputBuilder = new FormInputBuilder();
    }
    public function formStart(string $actionRoute): void
    {
        $this->form .= sprintf("<form action='%s' method='POST'>", $actionRoute);
    }
    public function formEnd(string $cssClasses = ''): void
    {
        $this->form .= sprintf("<button class='%s'>Submit</button></form>", $cssClasses);
    }
    public function add(string $inputType, array $attr = [])
    {
        $element[] = $this->formInputBuilder->add($inputType, $attr);
        return $this;
       
    }

    /**
     * Method to add html element like div opening/closing tags and other stuff
     * @param string $elements html element
     */
    public function addHtml(string $element): void
    {
        $this->form .= sprintf('%s', $element);
    }
    public function build()
    {
        $this->elements['html'] =  $this->formInputBuilder->build();
        return $this;
    }
    public function getForm(string $actionRoute)
    {
        $this->form .= $this->formStart(actionRoute: $actionRoute);
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