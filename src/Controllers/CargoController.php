<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Controllers\AbstractController;
use App\Forms\CargoForm;
use App\Forms\SearchColumnForm;
use App\Forms\Validators\FormValidator;
use App\Helpers\Url;
use App\Models\Entities\CargoEntity;
use App\Models\Repositories\AirportRepository;
use App\Models\Repositories\CargoRepository;
use App\Services\MapHandler;
use App\Services\Router;
use App\Services\SearchInquirer;

/**
 * all pages are stored here. There are accessible for
 * everyone.
 */
class CargoController extends AbstractController
{
  /**
   * Required function attaches all routes of the controller
   */
  public function attachRoutes(Router $router): void
  {

    $routes = [
       'orders' => ['page', 'sortBy', 'sortOrder'],
       'processOrder' => ['id'],
       'manageOrder' => ['id'],
       'updateOrder' => ['id'],
       'generateRandomOrders' => ['amount']
  ];
  $router->attachRoutes('CargoController', $routes);  
  }

  public function orders(int $page, string $sortBy, string $sortOrder): void
  {
    $searchString = '';
    $searchColumn = '';
    $cargoRepo = new CargoRepository();
   
    $searchForm = new SearchColumnForm(action: '/orders/1/id/asc/', entity: 'cargo');
    
    // if search form was submitted check entered data
     /**
     * SearchInquirer is class which implements search engine
     * for SerachInterface classes.
     */
    $searchInq = new SearchInquirer();
    $data = $searchInq->processSearchWithPagination(
              data: $_GET, 
              page: $page, 
              repository: $cargoRepo,
              searchForm: $searchForm,
              sortBy: $sortBy,
              sortOrder: $sortOrder
    );

    $cargos = $data['results'];
    $pages = $data['pages'];
    if (isset($data['searchString'])  && (isset($data['searchColumn']))) {
      $searchString = $data['searchString'];
      $searchColumn = $data['searchColumn'];
    }

    // return amount of pages 
    echo $this->twig->render(
      'cargos.html.twig',
      [
        'route' => 'orders',
        'cargos' => $cargos,
        'flashes' => App::$app->flashMessenger->get(),
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
  public function processOrder(int $id)
  {
   
    $form = new CargoForm();
    $cargoRepo = new CargoRepository();

    if (!empty($_POST)) {

      $cargo = new CargoEntity();
      $data = $_POST;
      // form alread filled
      // processing here
      $validator = new FormValidator();
      $errors = [];
      
      // TODO: this section must be optimised
   
      $cargo->setCityFrom((int)$data['city_from']);
      $cargo->setCityTo((int)$data['city_to']);
      $cargo->setCustomer((int)$data['customer_id']);
      $cargo->setWeight((int)$data['weight']);
      $cargo->setSize((int)$data['size']);
      $cargo->setValue((int)$data['value']);
      
      
        if ($errors) {
          forEach($errors as $error) {
            $this->flashMessenger->add($error);
            // we have errors 
            // go back to form and fix it by user
          } 
          $form->setData($cargo); 
        } else {
          // if id is set means we are editing existing entry
          // add some extra data to the object
          if (isset($data['id'])) {
           $cargo->setId((int)$data['id']);
          }
      
          $cargoRepo->persistOrder($cargo);
        $this->flashMessenger->add('Operation done.');
         Url::redirect('/orders/1/id/asc');
         return;
        } // form processing ends here
    }
    if ($id != 0) {
      $cargo = $cargoRepo->getById($id);
      $form->setData($cargo);
    }
    echo $this->twig->render('process-cargo.html.twig', 
                          ['form' => $form->getForm(),
                          'flashes' => $this->flashMessenger->get()
                        ]);
  }

  /**
   * Displays single order with all details and maps 
   * @param int $id Id of the order
   */
  public function manageOrder(int $id): void
  {
    $cargoRepo = new CargoRepository();
    $cargo = $cargoRepo->getSingleCargoById($id);
    $airportRepo = new AirportRepository();
    $airports = $airportRepo->getAll();
    $cargo['location_origin'] = MapHandler::PointToLocation($cargo['location_origin']);
    $cargo['location_destination'] = MapHandler::PointToLocation($cargo['location_destination']);
 
  echo $this->twig->render('manage-cargo.html.twig', [
      'cargoNo' => $id,
      'cargo' => $cargo,
      'airports' => $airports
    ]);
  }

  /**
   * This function updates order status (if delivered or not),
   * redirects delivery, cancels delivery
   * @param int $id Id of the order
   */
  public function updateOrder(int $id): void
  {
    $cargoRepo = new CargoRepository();
    $data = $_GET;
    if (isset($data['status'])) {
      $status = (int)$data['status'];
      $cargoRepo->setStatus($id, $status);

      /**
       * If cargo is on delivery random delivery time is generated (for demo purposes)
       * TO DO: calc distance between cities and set correct delivery time
       */
        if ($status != 0 ) {
          $deliveryTime = rand(36,96);
          $cargoRepo->setDeliveryTime(id: $id, time: $deliveryTime);
        } 
    }
    if (isset($data['airportId'])) {
      $deliveryTime = rand(36,96);
      $cargoRepo->redirectDelivery($id, (int)$data['airportId']);
      $cargoRepo->setDeliveryTime(id: $id, time: $deliveryTime);
    }
    if ((isset($data['cancel']) && ($data['cancel'] === 'yes')) ) {
      $cargoRepo->setStatus($id, status: 0);
    }
    Url::redirect("/manageOrder/{$id}");
    return;
  }

  /**
   * Generates random orders and adds to the database
   * @param int $amount Amount of orders to be generated
   */

  public function generateRandomOrders(int $amount): void
  {
    $cargoRepo = new CargoRepository();
    $cargoRepo->generateRandomOrders($amount);
    Url::redirect('/orders/1/id/asc');
  }
}
