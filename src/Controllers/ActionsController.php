<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\App;
use App\Controllers\AbstractController;
use App\Forms\PlaneForm;
use App\Forms\UserLoginForm;
use App\Forms\Validators\FormValidator;
use App\Helpers\Url;
use App\Models\Entities\AeroplaneEntity;
use App\Models\Entities\AircraftEntity;
use App\Models\Repositories\AeroplaneRepository;
use App\Models\Repositories\AircraftRepository;
use App\Services\Authorisation;
use App\Services\Router;

class ActionsController extends AbstractController
{

    /**
     * Required function attaches all routes of the controller
     */
   public function attachRoutes(Router $router)
   {

    // also all methods can be retrieved with ReflectionClass
    // TO BE DONE
    $router->attachRoute('ActionsController', 'aircraftAction');
   
   }


   
   public function aircraftAction()
   {
    $data = $_POST;
   
    $aeroplane = $data['aeroplaneId'];
    $base = $data['airportId'];
    $validate = new FormValidator();
    $aircraftName = $validate->sanitizeData($data['name']);
   

    $aircraft = new AircraftEntity();
     // if id is set means we are editing existing entry
     if (isset($data['id'])) {
      $aircraft->setId((int)$data['id']);
     }
    $aircraft->setAircraftName($aircraftName);
    $aircraft->setHoursDone(0);
    $aircraft->isInUse(0);
    $aircraft->setAirportBase((int)$base);
    $aircraft->setAeroplane((int)$aeroplane);

   $this->db->persist(new AircraftRepository(), $aircraft);
    Url::redirect('fleet');
   }

   
}