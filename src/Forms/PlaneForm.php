<?php

declare(strict_types = 1);

namespace App\Forms;

use App\Forms\FormBuilders\FormBuilder;
use App\Forms\InputTypes\EmailType;
use App\Forms\InputTypes\FileType;
use App\Forms\InputTypes\HiddenType;
use App\Forms\InputTypes\NumberType;
use App\Forms\InputTypes\TextType;
use App\Forms\InputTypes\PasswordType;
use App\Forms\InputTypes\SelectType;
use App\Forms\InputTypes\SubmitType;
use App\Models\Repositories\AeroplaneRepository;
use App\Models\Repositories\AirportRepository;

class PlaneForm 
{
    private array $elements;
    private FormBuilder $formBuilder;
    public function __construct()
    {
        $this->formBuilder = new FormBuilder('plane.php');
       
    } 

    public function getForm(array $exisitingData = [])
    {
        /**
         * Get array of aeroplanes from DB first.
         * We need them for select inputs.
         */

        $aeroplanes = $this->getAeroplaneModels();
        $selectPlanes = [];
        foreach ($aeroplanes as $plane) {
            $selectPlanes[$plane->getId()] = 
                            $plane->getVendor() . ' ' . $plane->getModel() 
                        ;
        }

        /** mySql Point to Array conversion
         * https://stackoverflow.com/a/42322503/1496972
         */
        $airports = $this->getAirports();

        if (count($exisitingData) > 0) {
           $planeId = $exisitingData['id'];
           $aircraftName = $exisitingData['aircraft_name'];
           $airportBaseId = $exisitingData['airport_base'];
           $aeroplaneId = $exisitingData['aeroplane'];
        } else {
            dump("no data");
        }
        $elements = $this->formBuilder
        ->add(
            TextType::class, 
            [
            'name' => 'name',
            'label' => 'Plane\'s name',
            'required' => 'required',
            'value' => $aircraftName ?? '',
            'labelCssClasses' => 'd-block ',
            'inputCssClasses' => 'd-block mt-2 class-control input-sm',
            ]
        )
        ->add(
            SelectType::class,
            [
                'name' => 'aeroplaneId',
                'options' => $selectPlanes,
                'label' => 'Select vendor and model',
                'labelCssClasses' => 'mt-4',
                'selectCssClasses' => 'width-small mt-2',
                'selectedValue' => $aeroplaneId ?? ''
            ]
        )
        ->add(
            SelectType::class,
            [
                'name' => 'airportId',
                'options' => $airports,
                'label' => 'Select base airport',
                'labelCssClasses' => 'mt-4',
                'selectCssClasses' => 'width-small mt-2',
                'selectedValue' => $airportBaseId ?? ''
            ]
        )
        ->add(
            HiddenType::class,
            [
                'param' => 'id',
                'data' => $planeId ?? ''
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
        ->getForm(actionRoute: '/aircraftAction');
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