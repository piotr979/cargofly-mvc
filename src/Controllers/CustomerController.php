<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Forms\CustomerForm;
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
    $customerRepo = new CustomerRepository();
    $customerRepo->getAllCustomersPaginated(
                page: 1,
                sortBy: 'customer_name', 
                sortOrder: 'asc'
              );

    echo $this->twig->render('customers.html.twig', ['route' => 'customers']);
  }
  public function addCustomer()
  {

    $form = new CustomerForm();

    if (!empty($_POST)) {
      $data = $_POST;
      dump($data);exit;
    }
  
    echo $this->twig->render('add-customer.html.twig', [
                      'form' => $form->getForm()
    ]);
  }
  public function editCustomer(int $id)
  {
    $form = new CustomerForm();
    echo $this->twig->render('edit-customer.html.twig', [
                      'form' => $form->getForm()
    ]
                   );
  }
}
