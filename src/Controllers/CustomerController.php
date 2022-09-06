<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Controllers\AbstractController;
use App\Forms\CustomerForm;
use App\Forms\SearchFleetForm;
use App\Forms\Validators\FormValidator;
use App\Helpers\Url;
use App\Models\Entities\CustomerEntity;
use App\Models\Repositories\CustomerRepository;
use App\Services\Router;
use FormRules;

/**
 * all pages are stored here. There are accessible for
 * everyone.
 */
class CustomerController extends AbstractController
{
  /**
   * Required function attaches all routes of the controller
   */
  public function attachRoutes(Router $router)
  {

    // also all methods can be retrieved with ReflectionClass
    // TO BE DONE
    $router->attachRoute('CustomerController', 'customers', ['page', 'sortBy', 'sortOrder']);
    $router->attachRoute('CustomerController', 'processCustomer', ['id']);
  
  }

  public function customers(int $page, string $sortBy, string $sortOrder)
  {
    $searchString = '';
    $searchColumn = '';
    $customerRepo = new CustomerRepository();
    $customerRepo->getAll();
   
    $searchForm = new SearchFleetForm();

    // if search form was already submitted
    if (isset($_GET['searchString']) && isset($_GET['column'])) {
      $searchString = $_GET['searchString'];
      $searchColumn = $_GET['column'];

      $customers = $customerRepo->getAllPaginated(
        page: $page,
        sortBy: $sortBy,
        sortOrder: $sortOrder,
        searchString: $searchString,
        searchColumn: $searchColumn
      );
      $pages = $customerRepo->countPages(
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
      $customers = $customerRepo->getAllPaginated(
        page: $page,
        sortBy: $sortBy,
        sortOrder: $sortOrder
      );

      $pages = $customerRepo->countPages(
        limit: 10
      );
    }
    // return amount of pages 
    echo $this->twig->render(
      'customers.html.twig',
      [
        'route' => 'customers',
        'customers' => $customers,
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
  public function processCustomer(int $id)
  {
    
    $form = new CustomerForm();
    $aircraftRepo = new CustomerRepository();
  //  dump($id);
    if (!empty($_POST)) {
      $data = $_POST;
      // form alread filled
      // processing here
      $validator = new FormValidator();
      $errors = $validator->isValid(values: $data, ommit: ['id', 'logo', 'street2']);
      $customer = new CustomerEntity();
    
      $customer->setCustomerName($data['customer_name']);
      $customer->setOwnerFName($data['owner_fname']);
      $customer->setOwnerLName($data['owner_lname']);
      $customer->setStreet1($data['street1']);
      $customer->setStreet2($data['street2'] ?? '');
      $customer->setCity($data['city']);
      $customer->setZipCode($data['zip_code']);
      $customer->setCountry($data['country']);
      $customer->setVat((int)$data['vat']);
      $customer->setLogo($data['logo'] ?? '');
      $customer->setId($id);
      // check if names exists in the database
      if ($id === 0 && ($aircraftRepo->checkIfExists($customer->getCustomerName(), 'customer_name'))) {
        $errors[] = 'Name already exists.';
      }
      $findInDB = $aircraftRepo->getWhere('id', 'customer_name', $customer->getCustomerName());
      if (isset($findInDB['id']) && ($findInDB['id'] != $id)) {
        $errors[] = 'Name already exists in the database.';

      }
      
        if ($errors) {
          forEach($errors as $error) {
            $this->flashMessenger->add($error);
            // we have errors 
            // go back to form and fix it by user
          } 
         dump($customer);
          $form->setData($customer); 
        } else {
          // if id is set means we are editing existing entry
          // add some extra data to the object
          if (isset($data['id'])) {
           $customer->setId((int)$data['id']);
          }
      
          $this->db->persist(new CustomerRepository(), $customer);
        $this->flashMessenger->add('Operation done.');
         Url::redirect('/customers/1/customer_name/asc');
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
}
