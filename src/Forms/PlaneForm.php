<?php

declare(strict_types = 1);

namespace App\Forms;

use App\Forms\FormBuilders\FormBuilder;
use App\Forms\InputTypes\EmailType;
use App\Forms\InputTypes\FileType;
use App\Forms\InputTypes\NumberType;
use App\Forms\InputTypes\TextType;
use App\Forms\InputTypes\PasswordType;
use App\Forms\InputTypes\SelectType;
use App\Forms\InputTypes\SubmitType;
use App\Models\Repositories\AeroplaneRepository;

class PlaneForm 
{
    private array $elements;
    private FormBuilder $formBuilder;
    public function __construct()
    {
        $this->formBuilder = new FormBuilder('plane.php');
       
    }

    public function getForm()
    {
        $planes = $this->getAeroplaneModels();

        $options = ['1' => 'one', '2' => 'two', '3' => 'three'];
        $elements = $this->formBuilder
        ->add(
            TextType::class, 
            [
            'name' => 'name',
            'label' => 'Name',
            'labelCssClasses' => 'd-block ',
            'inputCssClasses' => 'd-block mt-2 class-control input-sm',
            ]
        )
        ->add(
            SelectType::class,
            [
                'name' => 'model',
                'options' => $options,
                'label' => 'Select vendor and model',
                'labelCssClasses' => 'mt-4',
                'selectCssClasses' => 'width-small mt-2',
                'selectedValue' => '3'
            ]
        )
        ->add(
            SelectType::class,
            [
                'name' => 'city',
                'options' => $options,
                'label' => 'Select base airport',
                'labelCssClasses' => 'mt-4',
                'selectCssClasses' => 'width-small mt-2',
                'selectedValue' => '3'
            ]
        )
        ->add(
            SubmitType::class,
            [
            'buttonCssClasses' => 'd-block mt-4 btn btn-primary',
            'text' => 'Add'
            ]
        )
        ->build()
        ->getForm(actionRoute: 'loggingAction');
        ;
        return $elements;
    }
    private function getAeroplaneModels()
    {
        $planesRepo = new AeroplaneRepository();
        $planes = $planesRepo->getAllPlaneModels();
        dump($planes);exit;
    }
}