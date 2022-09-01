<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Services\Router;


class AdminController extends AbstractController
{

  /**
   * Required function attaches all routes of the controller
   */
  public function attachRoutes(Router $router): void
  {
    // also all methods can be retrieved with ReflectionClass
    // TO BE DONE

  }
  
}
