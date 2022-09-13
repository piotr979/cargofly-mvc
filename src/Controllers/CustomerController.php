<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Controllers\AbstractController;
use App\Forms\CustomerForm;
use App\Forms\SearchColumnForm;
use App\Forms\Validators\FormValidator;
use App\Helpers\Url;
use App\Models\Entities\CustomerEntity;
use App\Models\Repositories\CustomerRepository;
use App\Services\FileHandler;
use App\Services\Router;

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

    $routes = [
      'customers' => ['page', 'sortBy', 'sortOrder'],
      'processCustomer' => ['id']
      ];
 $router->attachRoutes('CustomerController', $routes);  
 }
 
  public function customers(int $page, string $sortBy, string $sortOrder)
  {
    $searchString = '';
    $searchColumn = '';
    $customerRepo = new CustomerRepository();
    $searchForm = new SearchColumnForm(action: '/customers/1/customer_name/asc/', entity: 'customer');
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
    $customerRepo = new CustomerRepository();

    if (!empty($_POST)) {

      $customer = new CustomerEntity();
      $data = $_POST;
     
      // form alread filled
      // processing here

      $validator = new FormValidator();
      $errors = $validator->isValid(values: $data, ommit: ['id', 'logo', 'street2']);
      
    
      // TODO: this section must be optimised, looks bad
      $customer->setCustomerName($data['customer_name']);
      $customer->setOwnerFName($data['owner_fname']);
      $customer->setOwnerLName($data['owner_lname']);
      $customer->setStreet1($data['street1']);
      $customer->setStreet2($data['street2'] ?? '');
      $customer->setCity($data['city']);
      $customer->setZipCode($data['zip_code']);
      $customer->setCountry($data['country']);
      $customer->setVat((int)$data['vat']);
      $customer->setId($id);
      // check if names exists in the database
      if ($id === 0 && ($customerRepo->checkIfExists($customer->getCustomerName(), 'customer_name'))) {
        $errors[] = 'Name already exists.';
      }
      $findInDB = $customerRepo->getWhere('id', 'customer_name', $customer->getCustomerName());
      if (isset($findInDB['id']) && ($findInDB['id'] != $id)) {
        $errors[] = 'Name already exists in the database.';

      }
      
        if ($errors) {
          forEach($errors as $error) {
            $this->flashMessenger->add($error);
            // we have errors 
            // go back to form and fix it by user
          } 
          $form->setData($customer); 
        } else {
          // if id is set means we are editing existing entry
          // add some extra data to the object
          if (!empty($_FILES)) {
            $fileHandler = new FileHandler();
            $fileName = $fileHandler->uploadFile($_FILES);
            if ($fileName) {
              $customer->setLogo($fileName);
            }
          } 
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
      $customer = $customerRepo->getById($id);
      $form->setData($customer);
    }
    echo $this->twig->render('process-customer.html.twig', 
                          ['form' => $form->getForm(),
                          'flashes' => $this->flashMessenger->getMessages()
                        ]);
  }
}
