<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Services\Router;

class MainController extends AbstractController
{

    /**
     * Required function attaches all routes of the controller
     */
   public function attachRoutes(Router $router)
   {

    // also all methods can be retrieved with ReflectionClass
    // TO BE DONE
    $router->attachRoute('MainController', 'home');
    $router->attachRoute('MainController', 'index');
    $router->attachRoute('MainController', 'street', ['number']);
    $router->attachRoute('MainController', 'multiParams', ['name', 'age']);
   }

   /**
    * Launched when url is empty ('/' precisely speaking)
    * However it can be changed in request class
    */
   public function index()
   {
    echo "test index";
   }
   /** 
    * Route: home
    */
   public function home()
   {
    $myView = $this->viewRenderer->viewBuilder('home.php');
    echo $myView;
   }
   

   public function street(int $number)
   {
    echo "The street number is " . $number;
   }
   public function multiParams
          (
          string $name,
          int $age
          )
    {
      echo "The street number is " . $name;
    }
}