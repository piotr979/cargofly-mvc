<?php

declare(strict_types = 1);

namespace App\Forms;

use App\Forms\FormBuilders\FormBuilder;
use App\Forms\InputTypes\HiddenType;
use App\Forms\InputTypes\NumberType;
use App\Forms\InputTypes\SelectType;
use App\Forms\InputTypes\SubmitType;
use App\Forms\InputTypes\TextType;
use App\Models\Entities\CargoEntity;
use App\Models\Repositories\AirportRepository;
use App\Models\Repositories\CustomerRepository;
use DateTime;
use DeliveryStatus;
use PDO;

class CargoForm 
{

    private FormBuilder $formBuilder;
    private int $id;
    private int $airportFrom;
    private int $airportTo;
    private int $status;
    private DateTime $timeTaken;


    public function __construct()
    {
        $this->formBuilder = new FormBuilder();
    } 
    public function setData(CargoEntity $cargo)
    {
        if ( $cargo->getId() != null) {
                $this->id = $cargo->getId();
        }
           $this->airportFrom = $cargo->getAirportFrom();
           $this->airportTo = $cargo->getAirportTo();
           $this->status = $cargo->getStatus();
           $this->timeTaken = $cargo->getTimeTaken();
           $this->weight = $cargo->getWeight();
           $this->size = $cargo->getSize();
     
    }
    public function getForm()
    {
        /**
         * Get array of aeroplanes from DB first.
         * We need them for select inputs.
         */
        // $aeroplanes = $this->getAeroplaneModels();
        // $selectPlanes = [];
        // foreach ($aeroplanes as $plane) {
        //     $selectPlanes[$plane->getId()] = 
        //                     [$plane->getVendor() . ' ' . $plane->getModel() => $plane->getPhoto()]
        //                 ;
        // }

        /** mySql Point to Array conversion
         * https://stackoverflow.com/a/42322503/1496972
         */
        $airports = $this->getAirports();
        $customers = $this->getCustomers();
        $elements = $this->formBuilder
        ->add(
            SelectType::class,
            [
                'name' => 'airport_from',
                'options' => $airports,
                'label' => 'Select origin',
                'labelCssClasses' => 'mt-4',
                'selectCssClasses' => 'width-xsmall mt-2',
                'selectedValue' => $this->airportFromId ?? 1
            ]
        )
        ->add(
            SelectType::class,
            [
                'name' => 'airport_to',
                'options' => $airports,
                'label' => 'Select destination',
                'labelCssClasses' => 'mt-4',
                'selectCssClasses' => 'width-xsmall mt-2',
                'selectedValue' => $this->airportToId ?? 1
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

    /**
     * This function fetches all available plane models from database
     */
    private function getCustomers(): array
    {
        $customerRepo = new CustomerRepository();
        $customers = $customerRepo->getAll(PDO::FETCH_CLASS);
        return $customers;
    }
    private function getAirports(): array
    {
        $airportsRepo = new AirportRepository();
        $airports = $airportsRepo->getAll(PDO::FETCH_CLASS);
        $airportsLocations = [];

        // if airport's city name is not found use airport name
        // and IF airports name is not found use airport code
        foreach ($airports as $airport) {
            $airportLocations[$airport->getId()] = 
                ($airport->getCity() === "" ? 
                        ($airport->getAirportName() === "" ? $airport->getCode() :
                                $airport->getAirportName() ) : $airport->getCity()) .
                 "&#47;" . $airport->getCountry();
        }
        asort($airportLocations);
        return $airportLocations;
    }
}