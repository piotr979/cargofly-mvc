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
    $router->attachRoute('CustomerController', 'addCustomer');
    $router->attachRoute('CustomerController', 'editCustomer', ['id']);
  
  }

  public function customers(int $page, string $sortBy, string $sortOrder)
  {
    $searchString = '';
    $searchColumn = '';
    $customerRepo = new CustomerRepository();
    $customerRepo->getAll();
   
    $dataz = $customerRepo->getById2(1);
    dump($dataz);
    $customerRepo->persist2(['name', 'address', 'tet'], ['John','Swift','PHP']);
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
  public function addCustomer()
  {

    $form = new CustomerForm();
    
    if (!empty($_POST)) {
      $data = $_POST;

      $validator = new FormValidator();
      foreach($data as $key => $value) {
        $data[$key] = $validator->sanitizeData($value);
      }

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

      $repo = new CustomerRepository();
      $repo->persister($customer);
     // $this->db->persist(new CustomerRepository, $customer);
      $this->flashMessenger->add('Operation done.');
          Url::redirect('/customers/1/customer_name/asc');
    }

    echo $this->twig->render('add-customer.html.twig', [
                      'form' => $form->getForm()
    ]);
  }
  public function editCustomer(int $id)
  {
    $customerRepo = new CustomerRepository();
    $customer = $customerRepo->getById(id: $id, tableName: 'customer', entityName: 'CustomerEntity');
    $form = new CustomerForm();
    $form->setData($customer);
   
    echo $this->twig->render('edit-customer.html.twig', [
                      'form' => $form->getForm()
                    ]);
  }
}
