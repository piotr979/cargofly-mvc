<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Services\Router;

class AdminController extends AbstractController
{

    /**
     * Required function attaches all routes of the controller
     */
   public function attachRoutes(Router $router)
   {

    // also all methods can be retrieved with ReflectionClass
    // TO BE DONE
    $router->attachRoute('AdminController', 'adminMain');
    $router->attachRoute('AdminController', 'multiAdmin', ['name']);
  
   }

   /**
    * Launched when url is empty ('/' precisely speaking)
    * However it can be changed in request class
    */

   public function adminMain()
   {
    echo "This is adminMain route.";
   }

   public function multiAdmin(string $name)
   {
    echo "This is multiAdmin route with " . $name;
   }
   
}
