<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Forms\FormInputBuilder;
use App\Forms\InputTypes\TextType;
use App\Services\Router;
use App\Forms\FormBuilder;
use App\Forms\UserLoginForm;
use FormRules;
use App\Forms\Validators\FormValidator;
use App\Helpers\Url;
use App\Services\Authorisation;

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
