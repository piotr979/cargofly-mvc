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
    $router->attachRoute('ActionsController', 'removeAction', ['id', 'entity']);
    $router->attachRoute('ActionsController', 'searchFleetAction');
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
   $this->flashMessenger->add('Operation done.');
    Url::redirect('/fleet/1/aircraft_name/asc');
   }

   public function removeAction(int $id, string $entity)
   {
    $repositoryName = "\App\Models\Repositories\\" . ucfirst($entity) . "Repository";
    $repo = new $repositoryName();

    if ($repo->remove($id)) {
        $this->flashMessenger->add('Item removed successfully');
        Url::redirect('/fleet/1/aircraft_name/asc');
    } else {
      $this->flashMessenger->add('Ups! Something wrong!');
    };
   }
   public function searchFleetAction()
   {
    $searchString = '';
    $column = '';
    if (isset($_POST['searchString'])) {
      $searchString = $_POST['searchString'];
    }
    if (isset($_POST['column'])) {
      $column = $_POST['column'];
    }
    $repo = new AircraftRepository();
    $results = $repo->searchString(
            search: $searchString,
            column: $column
    );

   // Url::redirect('/fleet/1/aircraft_name/asc/');

   }
   
}