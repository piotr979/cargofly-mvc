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
    $router->attachRoute('MainController', 'home');
    $router->attachRoute('MainController', 'index');
    $router->attachRoute('MainController', 'street', ['numbero']);
   }

   /** 
    * Route: home
    */
   public function home()
   {
    var_dump($this->view->renderView('home.php'));
   }
   
   public function index()
   {
    echo "test index";
   }
   public function street(int $number)
   {
    echo "The street number is " . $number;
   }
}