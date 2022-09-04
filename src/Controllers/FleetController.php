<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Controllers\AbstractController;
use App\Forms\PlaneForm;
use App\Forms\SearchFleetForm;
use App\Forms\Validators\FormValidator;
use App\Helpers\Url;
use App\Models\Entities\AeroplaneEntity;
use App\Models\Entities\AircraftEntity;
use App\Models\Repositories\AeroplaneRepository;
use App\Models\Repositories\AircraftRepository;
use App\Services\Router;
use FormRules;

/**
 * all pages are stored here. There are accessible for
 * everyone.
 */
class FleetController extends AbstractController
{

  /**
   * Required function attaches all routes of the controller
   */
  public function attachRoutes(Router $router)
  {

    // also all methods can be retrieved with ReflectionClass
    // TO BE DONE
    $router->attachRoute('FleetController', 'fleet', ['page', 'sortBy', 'sortOrder']);
    $router->attachRoute('FleetController', 'addPlane');
    $router->attachRoute('FleetController', 'editPlane', ['id']);
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
    dump($fleetRepo->getById2(2));
    $searchForm = new SearchFleetForm();
    $pl = $fleetRepo->getAllPaginated2(
            page: $page, 
            sortBy: $sortBy,
            sortOrder: $sortOrder
    );
    dump($pl);exit;
    
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

  public function addPlane()
  {
    $form = new PlaneForm();
    
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
                ]
                );
        // check if name exists in the database
        $aircraftRepo = new AircraftRepository();
        if ($aircraftRepo->checkIfExists(
                            entry: $aircraftName , 
                            column: 'aircraft_name',
                            table: 'aircraft')) {
                              $errors[] = 'Name already exists.';
                            };

        // if errors stop processing form and return to the route.
        if ($errors) {
          forEach($errors as $error) {
            $this->flashMessenger->add($error);
            // we have errors 
            // go back to form and fix it by user
            $form->setData(
              [
               'aircraft_name' => $aircraftName,
                'airport_base' => $base,
                'aeroplane' => $aeroplane
              ]
              );
          }  
        } else {
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
         Url::redirect('/fleet/1/aircraft_name/asc/noString/noColumn');
        } // form processing ends here
      }
    $planesRepo = new AeroplaneRepository($this->conn);
    $planes = $planesRepo->getAllPlaneModels();
    
    $formReady = $form->getForm();
    echo $this->twig->render('add-plane.html.twig', 
                          ['form' => $formReady,
                          'flashes' => App::$app->flashMessenger->getMessages()
                        ]);
  }
  public function editPlane(int $id)
  {
    $planesRepo = new AeroplaneRepository($this->conn);
    $plane = $planesRepo->getById(id: $id, tableName: 'aircraft', entityName: 'FleetEntity');
    $form = new PlaneForm();
    $form->setData($plane[0]);
    echo $this->twig->render('edit-plane.html.twig', 
    ['form' => $form->getForm()]);
  }

  public function addAeroplane()
  {
    $plane = new AeroplaneEntity();
    $plane->setVendor('vendor');
    $plane->setModel('modelik');
    $plane->setPayload(2312);
    $this->db->persist(new AeroplaneRepository(), $plane);
  }
}
