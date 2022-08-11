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
    $router->attachRoute('AdminController', 'homes');
  
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
   public function homes()
   {
    var_dump($this->view->renderView('home.php'));
   }
   
}
