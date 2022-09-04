<?php

declare(strict_types = 1);

namespace App\Forms;

use App\Forms\FormBuilders\FormBuilder;
use App\Forms\InputTypes\FileType;
use App\Forms\InputTypes\HiddenType;
use App\Forms\InputTypes\HtmlType;
use App\Forms\InputTypes\NumberType;
use App\Forms\InputTypes\TextType;
use App\Forms\InputTypes\SelectImageType;
use App\Forms\InputTypes\SelectType;
use App\Forms\InputTypes\SubmitType;
use App\Models\Entities\CustomerEntity;
use App\Models\Repositories\AeroplaneRepository;
use App\Models\Repositories\AirportRepository;

class CustomerForm 
{
    private FormBuilder $formBuilder;
    private int $id;
    private $data = [];
    public function __construct()
    {
        $this->formBuilder = new FormBuilder();
    } 
    public function setData(CustomerEntity $customer)
    {
      $getters = [];
      $this->customer = $customer;
      $class = get_class($customer);

      if ($class) {
            $getters = array_filter(get_class_methods($customer), function($method) {
                return 'get' === substr($method, 0, 3);
            });
        }

        // remmove getId method
        array_pop($getters);
        foreach ($getters as $getter)
        {
            $this->data[] = $customer->$getter();
        }
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
        // $airports = $this->getAirports();

        $elements = $this->formBuilder
        ->add(
            HtmlType::class,
            ['<div class="row">']
        )
        ->add(
            HtmlType::class,
            ['<div class="col-12 col-lg-4">']
        )
        ->add(
            TextType::class, 
            [
            'name' => 'customer_name',
            'label' => 'Company\'s name &#42;',
            'required' => 'required',
            'value' =>  $this->data[0] ?? '',
            'labelCssClasses' => 'd-block',
            'inputCssClasses' => 'd-block mt-1 class-control width-xsmall',
            ]
        )
        ->add(
            TextType::class, 
            [
            'name' => 'owner_fname',
            'label' => 'Owner\'s first name &#42;',
            'required' => 'required',
            'value' => $this->data[1] ?? '',
            'labelCssClasses' => 'd-block mt-3',
            'inputCssClasses' => 'd-block mt-1 class-control width-xsmall',
            ]
        )
        ->add(
            TextType::class, 
            [
            'name' => 'owner_lname',
            'label' => 'Owner\'s last name &#42;',
            'required' => 'required',
            'value' => $this->data[2] ?? '',
            'labelCssClasses' => 'd-block mt-3',
            'inputCssClasses' => 'd-block mt-1 class-control width-xsmall',
            ]
        )
        ->add(
            TextType::class, 
            [
            'name' => 'street1',
            'label' => 'Street address 1 &#42;',
            'required' => 'required',
            'value' => $this->data[3] ?? '',
            'labelCssClasses' => 'd-block mt-3',
            'inputCssClasses' => 'd-block mt-1 class-control width-xsmall',
            ]
        )
        ->add(
            TextType::class, 
            [
            'name' => 'street2',
            'label' => 'Street address 2',
            'value' => $this->data[4] ?? '',
            'labelCssClasses' => 'd-block mt-3',
            'inputCssClasses' => 'd-block mt-1 class-control width-xsmall',
            ]
        )
        ->add(
            HtmlType::class,
            ['</div>']
        )
        ->add(
            HtmlType::class,
            ['<div class="col-12 col-lg-6">']
        )
        ->add(
            TextType::class, 
            [
            'name' => 'city',
            'label' => 'City &#42;',
            'required' => 'required',
            'value' => $this->data[5] ?? '',
            'labelCssClasses' => 'd-block mt-3 mt-lg-0',
            'inputCssClasses' => 'd-block mt-1 class-control width-xsmall',
            ]
        )
        ->add(
            TextType::class, 
            [
            'name' => 'zip_code',
            'label' => 'Zip code &#42;',
            'required' => 'required',
            'value' =>  $this->data[6] ?? '',
            'labelCssClasses' => 'd-block mt-3',
            'inputCssClasses' => 'd-block mt-1 class-control width-xsmall',
            ]
        )
        ->add(
            TextType::class, 
            [
            'name' => 'country',
            'label' => 'Country &#42;',
            'required' => 'required',
            'value' => $this->data[7] ?? '',
            'labelCssClasses' => 'd-block mt-3',
            'inputCssClasses' => 'd-block mt-1 class-control width-xsmall',
            ]
        )
        ->add(
            NumberType::class, 
            [
            'name' => 'vat',
            'label' => 'Vat number &#42;',
            'value' => $this->data[8] ?? '',
            'labelCssClasses' => 'd-block mt-3',
            'inputCssClasses' => 'd-block mt-1 class-control width-xsmall',
            ]
        )
        ->add(
            HtmlType::class,
            ['</div>']
        )
        ->add(
            FileType::class, 
            [
            'name' => 'logo',
            'label' => 'Company logo',
            'value' => $this->data[9] ?? '',
            'labelCssClasses' => 'd-block mt-3',
            'inputCssClasses' => 'logo-uploader d-block ms-3 ms-lg-2 mt-1 class-control',
            ]
        )
        ->add(
            HtmlType::class,
            ['</div>']
        )
        ->add(
            HiddenType::class,
            [
                'param' => 'id',
                'data' => $this->id ?? ''
            ]
        )
        ->add(
            HtmlType::class,
            ['<img id="image-preview" class="mt-4" />']
        )
        ->add(
            SubmitType::class,
            [
            'buttonCssClasses' => 'd-block mt-4 btn btn-primary',
            'text' => 'Add'
            ]
        )
        ->build()
        ->getForm(actionRoute: '/addCustomer');
        ;
        return $elements;
    }

    /**
     * This function fetches all available plane models from database
     */
    private function getAeroplaneModels(): array
    {
        $planesRepo = new AeroplaneRepository();
        $planes = $planesRepo->getAllPlaneModels();
        return $planes;
    }
    private function getAirports(): array
    {
        $airportsRepo = new AirportRepository();
        $airports = $airportsRepo->getAllAirports();
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