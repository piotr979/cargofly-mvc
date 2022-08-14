<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Forms\FormInputBuilder;
use App\Forms\InputTypes\TextType;
use App\Services\Router;
use App\Forms\FormBuilder;

class AdminController extends AbstractController
{

    /**
     * Required function attaches all routes of the controller
     */
   public function attachRoutes(Router $router): void
   {

    // also all methods can be retrieved with ReflectionClass
    // TO BE DONE
    $router->attachRoute('AdminController', 'adminMain');
    $router->attachRoute('AdminController', 'multiAdmin', ['name']);
    $router->attachRoute('AdminController', 'actionRoute');
  
   }

   /**
    * Launched when url is empty ('/' precisely speaking)
    * However it can be changed in request class
    */

   public function adminMain()
   {
    $formBuilder = new FormBuilder('action.php');
    $formInputBuilder = new FormInputBuilder();
    $elements = [];
    $elements[] = $formBuilder
            ->add(
                TextType::class, 
                [
                'name' => 'name',
                'placeholder' => 'Hodler',
                'label' => 'This is label',
                'labelCssClasses' => 'd-block',
                'inputCssClasses' => 'd-block'
                ]
            )
            ->add(
                TextType::class, 
                [
                'name' => 'age',
                'placeholder' => 'Butek',
                'labelCssClasses' => 'd-block']
            )
            ->build()
            ->getForm(actionRoute: 'actionRoute');
            ;

    echo $elements[0];
   }
   public function actionRoute()
   {
    dump($_POST);
   }
   public function multiAdmin(string $name)
   {
    echo "This is multiAdmin route with " . $name;
   }
   
}
