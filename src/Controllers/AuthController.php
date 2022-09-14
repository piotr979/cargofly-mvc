<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Controllers\AbstractController;
use App\Forms\UserLoginForm;
use App\Helpers\Url;
use App\Services\Authorisation;
use App\Services\Router;
use App\Forms\Validators\FormValidator;
use FormRules;

class AuthController extends AbstractController
{
  public function attachRoutes(Router $router): void
  {
    $routes = ['login', 'logout', 'loggingAction'];
    $router->attachRoutes('AuthController', $routes);
  }

  public function login()
  {
    $loginForm = new UserLoginForm();
    if (Authorisation::isUserLogged()) {
      Url::redirect('dashboard');
    }
    echo $this->twig->render(
      'login.html.twig',
      [
        'form' => $loginForm->getForm(),
        'flashes' => App::$app->flashMessenger->get()
      ]
    );
  }

  public function logout(): void
  {
    Authorisation::logOut();
    $this->flashMessenger->add('You\'ve been successfully logged out.');
    Url::redirect('login');
  }

  /**
   * This function is triggered when user attempts to login in
   */
  public function loggingAction(): void
  {
    $data = $_POST;
    $errors = [];
    $validator = new FormValidator();

    $errors = $validator->validateForm(
      $data,
      [
        'login' => [FormRules::Required, FormRules::Email],
        'password' => [FormRules::Required,[FormRules::MinLength, '6']]
      ]
    );
    if (empty($errors)) {
      // if validation's error didn't occur try to login
      if (Authorisation::login(login: $data['login'],password: $data['password'])) {
        Url::redirect('dashboard');
      } else {
        $this->flashMessenger->add('Wrong credentials');
        Url::redirect('login');
      }
    } else {
      foreach ($errors as $error) {
        $this->flashMessenger->add($error);
        Url::redirect('login');
      }
    }
  }
}
