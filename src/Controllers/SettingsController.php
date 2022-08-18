<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Forms\UserLoginForm;
use App\Helpers\Url;
use App\Services\Authorisation;
use App\Services\Router;

class SettingsController extends AbstractController
{

    /**
     * Required function attaches all routes of the controller
     */
   public function attachRoutes(Router $router)
   {

    // also all methods can be retrieved with ReflectionClass
    // TO BE DONE
    $router->attachRoute('SettingsController', 'settings');
   }

   public function settings()
   {
    echo $this->twig->render('settings.html.twig', ['route' => 'settings']);
   }
}