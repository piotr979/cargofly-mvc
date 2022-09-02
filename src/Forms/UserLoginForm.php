<?php

declare(strict_types = 1);

namespace App\Forms;

use App\Forms\FormBuilders\FormBuilder;
use App\Forms\InputTypes\EmailType;
use App\Forms\InputTypes\TextType;
use App\Forms\InputTypes\PasswordType;
use App\Forms\InputTypes\SubmitType;
class UserLoginForm 
{
    private array $elements;
    private FormBuilder $formBuilder;
    public function __construct()
    {
        $this->formBuilder = new FormBuilder();
    }

    public function getForm()
    {
        $elements = $this->formBuilder
        ->add(
            TextType::class, 
            [
            'name' => 'login',
            'placeholder' => 'admin@admin.com',
            'label' => 'Login',
            'labelCssClasses' => 'd-block ',
            'inputCssClasses' => 'd-block mt-2 class-control input-sm',
            ]
        )
        ->add(
            PasswordType::class, 
            [
            'name' => 'password',
            'label' => 'Password',
            'labelCssClasses' => 'd-block mt-3',
            'inputCssClasses' => 'd-block mt-2'
             ]
        )
        ->add(
            SubmitType::class,
            [
            'buttonCssClasses' => 'd-block mt-4 btn btn-primary',
            'text' => 'Login'
            ]
        )
        ->build()
        ->getForm(actionRoute: 'loggingAction');
        ;
        return $elements;
    }
}