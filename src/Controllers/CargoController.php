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
use App\Models\Repositories\CargoRepository;
use App\Services\FileHandler;
use App\Services\Router;
use DateTime;

/**
 * all pages are stored here. There are accessible for
 * everyone.
 */
class CargoController extends AbstractController
{
  /**
   * Required function attaches all routes of the controller
   */
  public function attachRoutes(Router $router)
  {

    // also all methods can be retrieved with ReflectionClass
  // TO BE DONE
    $router->attachRoute('CargoController', 'orders', ['page', 'sortBy', 'sortOrder']);
    $router->attachRoute('CargoController', 'processOrder', ['id']);
  
  }

  public function orders(int $page, string $sortBy, string $sortOrder)
  {
    $searchString = '';
    $searchColumn = '';
    $cargoRepo = new CargoRepository();
   
    $searchForm = new SearchColumnForm(action: '/orders/1/id/asc/', entity: 'cargo');
    // if search form was already submitted
    if (isset($_GET['searchString']) && isset($_GET['column'])) {
      $searchString = $_GET['searchString'];
      $searchColumn = $_GET['column'];
      $customers = $cargoRepo->getAllPaginated(
        page: $page,
        sortBy: $sortBy,
        sortOrder: $sortOrder,
        searchString: $searchString,
        searchColumn: $searchColumn
      );
      $pages = $cargoRepo->countPages(
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
      $cargos = $cargoRepo->getAllPaginated(
        page: $page,
        sortBy: $sortBy,
        sortOrder: $sortOrder
      );

      $pages = $cargoRepo->countPages(
        limit: 10
      );
    }
    // return amount of pages 
    echo $this->twig->render(
      'cargos.html.twig',
      [
        'route' => 'cargos',
        'cargos' => $cargos,
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
  public function processOrder(int $id)
  {
   
    $form = new CargoForm();
    $cargoRepo = new CargoRepository();

    if (!empty($_POST)) {

      $cargo = new CargoEntity();
      dump($_POST);
      $data = $_POST;
     
      // form alread filled
      // processing here

      $validator = new FormValidator();
      $errors = [];
      
    
      // TODO: this section must be optimised
   
      $cargo->setAirportFrom((int)$data['airport_from']);
      $cargo->setAirportTo((int)$data['airport_to']);
      $cargo->setCustomer((int)$data['customer_id']);
      $cargo->setWeight((int)$data['weight']);
      $cargo->setSize((int)$data['size']);
      $cargo->setValue((int)$data['value']);
      $cargo->setStatus(0);

      // check if names exists in the database
      // if ($id === 0 && ($cargoRepo->checkIfExists($customer->getCustomerName(), 'customer_name'))) {
      //   $errors[] = 'Name already exists.';
      // }
      // $findInDB = $customerRepo->getWhere('id', 'customer_name', $customer->getCustomerName());
      // if (isset($findInDB['id']) && ($findInDB['id'] != $id)) {
      //   $errors[] = 'Name already exists in the database.';

      // }
      
        if ($errors) {
          forEach($errors as $error) {
            $this->flashMessenger->add($error);
            // we have errors 
            // go back to form and fix it by user
          } 
         dump($cargo);
          $form->setData($cargo); 
        } else {
          // if id is set means we are editing existing entry
          // add some extra data to the object
          if (isset($data['id'])) {
           $cargo->setId((int)$data['id']);
          }
      
          $cargoRepo->persistOrder($cargo);
        $this->flashMessenger->add('Operation done.');
         Url::redirect('/customers/1/customer_name/asc');
         return;
        } // form processing ends here
    }
    if ($id != 0) {
      $customer = $cargoRepo->getById($id);
      $form->setData($cargo);
    }
    echo $this->twig->render('process-cargo.html.twig', 
                          ['form' => $form->getForm(),
                          'flashes' => $this->flashMessenger->getMessages()
                        ]);
  }
}
