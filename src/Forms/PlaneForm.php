<?php

declare(strict_types = 1);

namespace App\Forms;

use App\Forms\AbstractForm;
use App\Forms\FormBuilders\FormBuilder;
use App\Forms\InputTypes\HiddenType;
use App\Forms\InputTypes\TextType;
use App\Forms\InputTypes\SelectImageType;
use App\Forms\InputTypes\SelectType;
use App\Forms\InputTypes\SubmitType;
use App\Models\Entities\AircraftEntity;


class PlaneForm extends AbstractForm
{
    private array $elements;
    private FormBuilder $formBuilder;
    private int $id;
    private string $aircraftName;
    private int $airportBaseId;
    private int $aeropolaneId;

    public function __construct()
    {
        $this->formBuilder = new FormBuilder();
    } 
    public function setData(AircraftEntity $plane)
    {
        if ( $plane->getId() != null) {
                $this->id = $plane->getId();
        }
            $this->aircraftName = $plane->getAircraftName();
            $this->airportBaseId = $plane->getAirportBase();
            $this->aeroplaneId = $plane->getAeroplane();
     
    }
    public function getForm()
    {
        /**
         * Get array of aeroplanes from DB first.
         * We need them for select inputs.
         */
        $aeroplanes = $this->getAeroplaneModels();
        $selectPlanes = [];
        foreach ($aeroplanes as $plane) {
            $selectPlanes[$plane->getId()] = 
                            [$plane->getVendor() . ' ' . $plane->getModel() => $plane->getPhoto()]
                        ;
        }

        /** mySql Point to Array conversion
         * https://stackoverflow.com/a/42322503/1496972
         */
        $airports = $this->getAirports();
        $elements = $this->formBuilder
        ->add(
            TextType::class, 
            [
            'name' => 'name',
            'label' => 'Plane\'s name',
            'required' => 'required',
            'value' => $this->aircraftName ?? '',
            'labelCssClasses' => 'd-block ',
            'inputCssClasses' => 'd-block mt-2 class-control width-xsmall',
            ]
        )
        ->add(
            SelectImageType::class,
            [
                'name' => 'aeroplaneId',
                'options' => $selectPlanes,
                'label' => 'Select vendor and model',
                'labelCssClasses' => 'mt-4',
                'selectCssClasses' => 'width-small mt-2',
                'selectedValue' => $this->aeroplaneId ?? ''
            ]
        )
        ->add(
            SelectType::class,
            [
                'name' => 'airportId',
                'options' => $airports,
                'label' => 'Select base airport',
                'labelCssClasses' => 'mt-4',
                'selectCssClasses' => 'width-xsmall mt-2',
                'selectedValue' => $this->airportBaseId ?? 1
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
        ->getForm(actionRoute: '/processPlane/' . ($this->id ?? 0) );
        ;
        return $elements;
    }
}