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

class AdminController extends AbstractController
{

  /**
   * Required function attaches all routes of the controller
   */
  public function attachRoutes(Router $router): void
  {

    // also all methods can be retrieved with ReflectionClass
    // TO BE DONE
    $router->attachRoute('AdminController', 'adminMain');
    $router->attachRoute('AdminController', 'multiAdmin', ['name']);
    $router->attachRoute('AdminController', 'actionRoute');
    $router->attachRoute('AdminController', 'loggingAction');
  }

  /**
   * Launched when url is empty ('/' precisely speaking)
   * However it can be changed in request class
   */

  public function adminMain()
  {
    $form = new UserLoginForm();

    echo $this->twig->render('home.html.twig', ['form' => $form->getForm()]);
  }
  public function actionRoute()
  {
    dump($_POST);
  }
  public function multiAdmin(string $name)
  {
    echo "This is multiAdmin route with " . $name;
  }
  public function loggingAction()
  {
    $validator = new FormValidator();
    $validator->validateForm(
      $_POST,
      [
        'login' => [
          FormRules::Required,
          FormRules::Email
        ],
        'password' => [
          FormRules::Required,
          [FormRules::MinLength, '6']
        ]
      ]
    );
  }
}
