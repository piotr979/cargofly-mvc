<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Services\Router;


/**
 * all pages are stored here. There are accessible for
 * everyone.
 */
class OrderController extends AbstractController
{

  /**
   * Required function attaches all routes of the controller
   */
  public function attachRoutes(Router $router)
  {

    // also all methods can be retrieved with ReflectionClass
    // TO BE DONE
    $router->attachRoute('OrderController', 'orders');
  }

  public function orders()
  {
    echo $this->twig->render('orders.html.twig', ['route' => 'orders']);
  }
}
