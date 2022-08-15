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
        $this->formBuilder = new FormBuilder('action.php');
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
            'labelCssClasses' => 'd-block',
            'inputCssClasses' => 'd-block',
            ]
        )
        ->add(
            PasswordType::class, 
            [
            'name' => 'password',
            'label' => 'Password',
            'labelCssClasses' => 'd-block',
            'inputCssClasses' => 'd-block mt-2'
             ]
        )
        ->add(
            SubmitType::class,
            [
            'buttonCssClasses' => 'd-block mt-4',
            'text' => 'submittick'
            ]
        )
        ->build()
        ->getForm(actionRoute: 'loggingAction');
        ;
        return $elements;
    }
}