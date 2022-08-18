<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Forms\UserLoginForm;
use App\Helpers\Url;
use App\Services\Authorisation;
use App\Services\Router;
use App\Forms\Validators\FormValidator;
use FormRules;

class AuthController extends AbstractController
{
    public function attachRoutes(Router $router)
    {
        $router->attachRoute('AuthController', 'login');
        $router->attachRoute('AuthController', 'logout');
        $router->attachRoute('AuthController', 'loggingAction');
    }

    public function login()
   {
    $loginForm = new UserLoginForm();
    if (Authorisation::isUserLogged()) {
        Url::redirect('dashboard');
    }
    echo $this->twig->render('login.html.twig', 
              [
              'form' => $loginForm->getForm()
              ]);
   }
   public function logout()
   {
    Authorisation::logOut();
    Url::redirect('login');
   }
   public function loggingAction()
  {
    $data = $_POST;

    $validator = new FormValidator();
   
    $errors = $validator->validateForm(
      $data,
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
    if (empty($errors)) {
      
      // if validation's error didn't occur try to login
      $status = Authorisation::login(
                        login: $data['login'], 
                        password: $data['password'] 
                        );
      Url::redirect('dashboard');
    } else {
      foreach ($errors as $error) {
        echo $error . '<br>' ;
      }
    }
    
  }
} 