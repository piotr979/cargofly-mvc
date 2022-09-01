<?php

declare(strict_types = 1);

namespace App\Forms;

use App\Forms\FormBuilders\FormBuilder;
use App\Forms\InputTypes\HiddenType;
use App\Forms\InputTypes\TextType;
use App\Forms\InputTypes\SelectImageType;
use App\Forms\InputTypes\SelectType;
use App\Forms\InputTypes\SubmitType;
use App\Models\Repositories\AeroplaneRepository;
use App\Models\Repositories\AirportRepository;

class SearchFleetForm 
{
    private array $elements;
    private FormBuilder $formBuilder;
    private string $searchString;
    private int $searchColumn;
    public function __construct()
    {
        $this->formBuilder = new FormBuilder('plane.php');
       
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
            'placeholder' => 'Search fleet',
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
                'options' => [
                    'aircraft_name' => 'Name',
                    'model' => 'Model',
                    'payload' => 'Capacity',
                    'city' => 'Airport'],
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
        ->getForm(actionRoute: '/fleet/1/aircraft_name/asc/', 
                method: "GET", 
                cssClasses: 'd-flex flex-column flex-md-row align-items-center align-items-md-start my-2');
        ;
        return $elements;
    }
}