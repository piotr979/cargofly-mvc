<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Helpers\Url;
use App\Services\Authorisation;
use App\Services\Router;


/**
 * all pages are stored here. There are accessible for
 * everyone.
 */
class MainController extends AbstractController
{

  /**
   * Required function attaches all routes of the controller
   */
  public function attachRoutes(Router $router)
  {

    // also all methods can be retrieved with ReflectionClass
    // TO BE DONE
    $router->attachRoute('MainController', 'index');
    $router->attachRoute('MainController', 'dashboard');
    $router->attachRoute('MainController', 'routes');
  }

  /**
   * Launched when url is empty ('/' precisely speaking)
   * However it can be changed in request class
   */
  public function index()
  {
    if (!Authorisation::isUserLogged()) {
      Url::redirect('login');
    } else {
      Url::redirect('dashboard');
    }
  }

  /** 
   * Home page
   */
  public function dashboard()
  {
    echo $this->twig->render('dashboard.html.twig', ['route' => 'dashboard']);

    // when twig not in use:
    //$myView = $this->viewRenderer->viewBuilder('home.php');
    // echo $myView;
  }

  public function routes()
  {
    echo $this->twig->render('routes.html.twig', ['route' => 'routes']);
  }
}
