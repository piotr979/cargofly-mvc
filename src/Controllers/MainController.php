<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Helpers\Url;
use App\Models\Repositories\AircraftRepository;
use App\Models\Repositories\CargoRepository;
use App\Models\Repositories\CustomerRepository;
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
  public function attachRoutes(Router $router): void
  {
    $routes = ['index', 'dashboard'];
    $router->attachRoutes('MainController', $routes);
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
    /**
     * Data below are for front page of the website (dashboard)
     */
    $cargoRepo = new CargoRepository();
    $customerRepo = new CustomerRepository();
    $aircraftRepo = new AircraftRepository();

    list($dataOrders, $dataIncomes) = $cargoRepo->getDeliveredCargosByDate();
    $dataPlanes = $aircraftRepo->getPlanesMonthlyByDate();
    $dataCustomers = $customerRepo->getCustomersMonthlyByDate();

    // to display most regular customers (2 of them)
    $topCustomers = $customerRepo->getTopCustomers(limit: 2);

    $awaitingOrders = $cargoRepo->getAwaitingOrders(limit: 3);
    echo $this->twig->render('dashboard.html.twig',
           [
            'route' => 'dashboard',
            'dataChartOrders' => $dataOrders,
            'ordersShipped' => array_sum($dataOrders),
            'dataChartPlanes' => $dataPlanes,
            'planesAmount' => array_sum($dataPlanes),
            'dataChartCustomers' => $dataCustomers,
            'customersAmount' => array_sum($dataCustomers),
            'dataChartIncomes' => $dataIncomes,
            'topCustomers' => $topCustomers,
            'awaitingOrders' => $awaitingOrders
           ]
           );

    // when twig not in use:
    //$myView = $this->viewRenderer->viewBuilder('home.php');
    // echo $myView;
  }
}
