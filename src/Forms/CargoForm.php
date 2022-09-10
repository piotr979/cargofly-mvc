<?php

declare(strict_types = 1);

namespace App\Forms;

use App\Forms\FormBuilders\FormBuilder;
use App\Forms\InputTypes\HiddenType;
use App\Forms\InputTypes\NumberType;
use App\Forms\InputTypes\SelectType;
use App\Forms\InputTypes\SubmitType;
use App\Models\Entities\CargoEntity;
use DateTime;
use App\Forms\AbstractForm;
use PDO;

class CargoForm extends AbstractForm
{

    private FormBuilder $formBuilder;
    private int $id;
    private int $airportFrom;
    private int $airportTo;
    private int $status;
    private int $timeTaken;
    private int $value;

    public function __construct()
    {
        $this->formBuilder = new FormBuilder();
    } 
    public function setData(CargoEntity $cargo)
    {
        if ( $cargo->getId() != null) {
                $this->id = $cargo->getId();
        }
           $this->airportFrom = $cargo->getCityFrom();
           $this->airportTo = $cargo->getCityTo();
           $this->status = $cargo->getStatus();
           $this->timeTaken = $cargo->getTimeTaken();
           $this->weight = $cargo->getWeight();
           $this->size = $cargo->getSize();
           $this->value = $cargo->getValue();
    }
    public function getForm()
    {
       

        /** mySql Point to Array conversion
         * https://stackoverflow.com/a/42322503/1496972
         */
        $airports = $this->getAirports();
       
        $customers = $this->getAllCustomersNames();
        $elements = $this->formBuilder

        ->add(
            SelectType::class,
            [
                'name' => 'city_from',
                'options' => $airports,
                'label' => 'Select origin',
                'labelCssClasses' => 'mt-4',
                'selectCssClasses' => 'width-xsmall mt-2',
                'selectedValue' => $this->airportFrom ?? 1
            ]
        )
        ->add(
            SelectType::class,
            [
                'name' => 'city_to',
                'options' => $airports,
                'label' => 'Select destination',
                'labelCssClasses' => 'mt-4',
                'selectCssClasses' => 'width-xsmall mt-2',
                'selectedValue' => $this->airportTo ?? 1
            ]
        )
        ->add(
            SelectType::class,
            [
                'name' => 'customer_id',
                'options' => $customers,
                'label' => 'Select customer',
                'labelCssClasses' => 'mt-4',
                'selectCssClasses' => 'width-xsmall mt-2',
                'selectedValue' => $this->customerId ?? 1
            ]
        )
        ->add(
            NumberType::class,
            [
                'name' => 'weight',
                'label' => 'Weight (in kg)',
                'labelCssClasses' => 'd-block mt-4',
                'inputCssClasses' => 'd-block width-xsmall mt-2',
                'value' => $this->weight ?? ''
            ]
        )
        ->add(
            NumberType::class,
            [
                'name' => 'size',
                'label' => 'Total size (w&ast;d&ast;h&ast;) in meters',
                'labelCssClasses' => 'd-block mt-4',
                'inputCssClasses' => 'd-block width-xsmall mt-2',
                'value' => $this->size ?? ''
            ]
        )
        ->add(
            NumberType::class,
            [
                'name' => 'value',
                'label' => 'Total value (in USD)',
                'labelCssClasses' => 'd-block mt-4',
                'inputCssClasses' => 'd-block width-xsmall mt-2',
                'value' => $this->value ?? ''
            ]
        )
        ->add(
            HiddenType::class,
            [
                'param' => 'id',
                'data' => $this->id ?? ''
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
        ->getForm(actionRoute: '/processOrder/' . ($this->id ?? 0) );
        ;
        return $elements;
    }
}