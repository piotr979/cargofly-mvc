<?php

declare(strict_types = 1);

namespace App\Forms;

use App\Forms\AbstractForm;
use App\Forms\FormBuilders\FormBuilder;
use App\Forms\InputTypes\SelectType;
use App\Forms\InputTypes\SubmitType;
use App\Services\Settings;

class SettingsForm extends AbstractForm
{
    private FormBuilder $formBuilder;
    private int $currencyValue;
    public function __construct()
    {
        $this->formBuilder = new FormBuilder();
    } 
    public function setData()
    {
        $this->currencyValue = Settings::getCurrencyIndex();
       
    }
    public function getForm()
    {
       
        $elements = $this->formBuilder
        ->add(
            SelectType::class,
            [
                'name' => 'currency',
                'options' => ['USD', 'EUR', 'GBP'],
                'label' => 'Currency',
                'labelCssClasses' => 'mt-4',
                'selectCssClasses' => 'width-xsmall mt-2',
                'selectedValue' => $this->currencyValue ?? 0
            ]
        )
        ->add(
            SubmitType::class,
            [
            'buttonCssClasses' => 'd-block mt-4 btn btn-primary',
            'text' => 'Done'
            ]
        )
        ->build()
        ->getForm(actionRoute: '/settings', method: "GET" );
        ;
        return $elements;
    }
}