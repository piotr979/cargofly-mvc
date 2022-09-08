<?php

declare(strict_types = 1);

namespace App\Forms;

use App\Forms\FormBuilders\FormBuilder;
use App\Forms\InputTypes\TextType;
use App\Forms\InputTypes\SelectType;
use App\Forms\InputTypes\SubmitType;

/**
 * It's search form available in customers/fleet,etc pages
 * Due to simplicity of this form, select and its options are
 * possible to build in getOptions section.
 */
class SearchColumnForm 
{
    private FormBuilder $formBuilder;
    private string $searchString;
    private string $action;
    private string $entity;
    private int $searchColumn;

    public function __construct(string $action, string $entity)
    {
        $this->formBuilder = new FormBuilder();
        $this->action = $action;
        $this->entity = $entity;
       
    } 

    public function setData(array $existingData = [])
    {
            $this->searchString = $existingData['searchString'];
            $this->searchColumn = (int)$existingData['searchColumn'];
    }

    public function getForm(string $exisitingData = "")
    {
       
        $elements = $this->formBuilder
        ->add(
            TextType::class, 
            [
            'name' => 'searchString',
            'placeholder' => 'Search...',
            'required' => 'required',
            'value' => $this->searchString ?? '',
            'labelCssClasses' => 'd-block ',
            'inputCssClasses' => 'd-block form-control width-xsmall',
            ]
        )
        ->add(
            SelectType::class,
            [
                'name' => 'column',
                'selectCssClasses' => 'ms-md-2 mt-3 mt-md-0 width-xsmall class-control',
                'options' => $this->getOptions(),
                'selectedValue' => $this->searchColumn ?? 1
            ]
        )
        ->add(
            SubmitType::class,
            [
                'buttonCssClasses' => 'ms-md-2 mt-2 mt-md-0 btn btn-primary'
            ]
        )
        ->build()
        ->getForm(actionRoute: $this->action, 
                method: "GET", 
                cssClasses: 'd-flex flex-column flex-md-row align-items-center align-items-md-start my-2');
        ;
        return $elements;
    }
    private function getOptions(): array
    {
        switch ($this->entity) {
            case "aircraft":
                return [
                    'aircraft_name' => 'Name',
                    'model' => 'Model',
                    'payload' => 'Capacity (in T)',
                    'city' => 'Airport'];
                break;
            case "customer":
                return [
                    'customer_name' => 'Company',
                    'owner_lname' => 'Owner',
                    'city' => 'City',
                    'country' => 'Country',
                    'vat' => 'Vat'
                ];
                break;
            case "cargo":
                return [
                    'id' => 'Order number',
                    'airport_from' => 'From',
                    'airport_to' => 'To',
                    'status' => 'Status',
                    ];
                    break;            
                
        }
    }
}