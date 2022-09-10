<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Controllers\AbstractController;
use App\Forms\PlaneForm;
use App\Forms\SearchColumnForm;
use App\Forms\SearchFleetForm;
use App\Forms\Validators\FormValidator;
use App\Helpers\Url;
use App\Models\Entities\AeroplaneEntity;
use App\Models\Entities\AircraftEntity;
use App\Models\Repositories\AeroplaneRepository;
use App\Models\Repositories\AircraftRepository;
use App\Services\Router;
use FormRules;

class FleetController extends AbstractController
{

  /**
   * Required function attaches all routes of the controller
   */
  public function attachRoutes(Router $router)
  {

    $router->attachRoute('FleetController', 'fleet', ['page', 'sortBy', 'sortOrder']);
    $router->attachRoute('FleetController', 'processPlane', ['id']);
    $router->attachRoute('FleetController', 'addAeroplane');
  }

  /** 
   * This page displays all planes available
   * @param int $page Current page 
   * @param string $sortBy column to be sorted by
   * @param string $sortOrder ascending/descending etc.
   */
  public function fleet(int $page, string $sortBy, string $sortOrder) 
  {
    $searchString = '';
    $searchColumn = '';
  
    $fleetRepo = new AircraftRepository();
    $searchForm = new SearchColumnForm(action: '/fleet/1/aircraft_name/asc/', entity: 'aircraft');
    
    // if search form was already submitted
    if (isset($_GET['searchString']) && isset($_GET['column'])) {
      $searchString = $_GET['searchString'];
      $searchColumn = $_GET['column'];

      $planes = $fleetRepo->getAllPaginated(
        page: $page,
        sortBy: $sortBy,
        sortOrder: $sortOrder,
        searchString: $searchString,
        searchColumn: $searchColumn
      );
      $pages = $fleetRepo->countPages(
        limit: 10,
        searchString: $searchString,
        searchColumn: $searchColumn
      );
      // prepares Data for search Form (if entered already)
      $searchForm->setData(
        [
          'searchString' => $searchString,
          'searchColumn' => $searchColumn
        ]
      );
    } else {
      $planes = $fleetRepo->getAllPaginated(
        page: $page,
        sortBy: $sortBy,
        sortOrder: $sortOrder
      );

      $pages = $fleetRepo->countPages(
        limit: 10
      );
    } 
    // return amount of pages 
    echo $this->twig->render(
      'fleet.html.twig',
      [
        'route' => 'fleet',
        'planes' => $planes,
        'flashes' => App::$app->flashMessenger->getMessages(),
        'pagesCount' => $pages,
        'page' => $page,
        'sortBy' => $sortBy,
        'sortOrder' => $sortOrder,
        'searchForm' => $searchForm->getForm(),
        'searchString' => $searchString,
        'searchColumn' => $searchColumn
      ]
    );
  }

  /**
   * This function is responsible for editing and adding new plane
   * If $id is different than zero means old entry is being edited.
   * @param int $id Id of the entry
   */
  public function processPlane(int $id)
  {
    $form = new PlaneForm();
    $aircraftRepo = new AircraftRepository();
    
    if (!empty($_POST)) {
      $data = $_POST;
      // form alread filled
      // processing here
      $aeroplane = $data['aeroplaneId'];
      $base = $data['airportId'];
      $validator = new FormValidator();
      $aircraftName = $validator->sanitizeData($data['name']);
      $errors = $validator->validateForm(
                $data,
                [
                  'name' => [
                    FormRules::InvalidCharacters,
                    [FormRules::MinLength, '4']
                  ]
                ]);
        // check if name exists in the database
      if ($id === 0 && ($aircraftRepo->checkIfExists($aircraftName, 'aircraft_name'))) {
        $errors[] = 'Name already exists.';
      }
      $findInDB = $aircraftRepo->getWhere('aircraft.id', 'aircraft.aircraft_name', $aircraftName);
      if (isset($findInDB['id']) && ($findInDB['id'] != $id)) {
        $errors[] = 'Name already exists in the database.';
      }
      
        $aircraft = new AircraftEntity();
        $aircraft->setAircraftName($aircraftName);
        $aircraft->setAirportBase((int)$base);
        $aircraft->setAeroplane((int)$aeroplane);

        if ($errors) {
          forEach($errors as $error) {
            $this->flashMessenger->add($error);
            // we have errors 
            // go back to form and fix it by user
            $form->setData($aircraft);
          }  
        } else {
          // if id is set means we are editing existing entry
          // add some extra data to the object
          if (isset($data['id'])) {
           $aircraft->setId((int)$data['id']);
          }
         $aircraft->setHoursDone(0);
         $aircraft->getInUse(0);
     
        $this->db->persist(new AircraftRepository(), $aircraft);
        $this->flashMessenger->add('Operation done.');
         Url::redirect('/fleet/1/aircraft_name/asc');
         return;
        } // form processing ends here
    }
    if ($id != 0) {
      $aircraft = $aircraftRepo->getById($id);
      $form->setData($aircraft);
    }
    echo $this->twig->render('add-plane.html.twig', 
                          ['form' => $form->getForm(),
                          'flashes' => $this->flashMessenger->getMessages()
                        ]);
  }

  /**
   * This function adds aeroplane. It's used for Fixtures only.
   */
  public function addAeroplane()
  {
    $plane = new AeroplaneEntity();
    $plane->setVendor('vendor');
    $plane->setModel('modelik');
    $plane->setPayload(2312);
    $this->db->persist(new AeroplaneRepository(), $plane);
  }
}
