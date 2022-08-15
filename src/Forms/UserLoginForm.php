<?php

declare(strict_types = 1);

namespace App\Forms;

use App\Forms\FormBuilders\FormBuilder;
use App\Forms\InputTypes\TextType;
class UserLoginForm 
{
    private array $elements;
    private FormBuilder $formBuilder;
    public function __construct()
    {
        $this->formBuilder = new FormBuilder('action.php');
    }

    public function getForm()
    {
        $elements = $this->formBuilder
        ->add(
            TextType::class, 
            [
            'name' => 'name',
            'placeholder' => 'Hodler',
            'label' => 'This is label',
            'labelCssClasses' => 'd-block',
            'inputCssClasses' => 'd-block'
            ]
        )
        ->add(
            TextType::class, 
            [
            'name' => 'age',
            'placeholder' => 'Butek',
            'labelCssClasses' => 'd-block']
        )
        ->build()
        ->getForm(actionRoute: 'actionRoute');
        ;
        return $elements;
    }
}