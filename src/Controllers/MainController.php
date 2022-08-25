<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\App;
use App\Controllers\AbstractController;
use App\Forms\PlaneForm;
use App\Forms\UserLoginForm;
use App\Helpers\Url;
use App\Models\Entities\AeroplaneEntity;
use App\Models\Repositories\AeroplaneRepository;
use App\Models\Repositories\AircraftRepository;
use App\Services\Authorisation;
use App\Services\Router;

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
    $router->attachRoute('MainController', 'orders');
    $router->attachRoute('MainController', 'fleet');
    $router->attachRoute('MainController', 'routes');
    $router->attachRoute('MainController', 'customers');
    $router->attachRoute('MainController', 'addPlane');
    $router->attachRoute('MainController', 'karlik', ['age']);
    $router->attachRoute('MainController', 'editPlane', ['id']);
    $router->attachRoute('MainController', 'addAeroplane');
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
  
   public function karlik(string $age)
  {
    echo $this->twig->render('dashboard.html.twig');
  }
   /** 
    * Route: home
    */
   public function dashboard()
   { 
    echo $this->twig->render('dashboard.html.twig', ['route' => 'dashboard']);
    
    // when twig not in use:
    //$myView = $this->viewRenderer->viewBuilder('home.php');
   // echo $myView;
   }

   public function orders()
   {  
    echo $this->twig->render('orders.html.twig', ['route' => 'orders']);
   }

   public function fleet()
   { 
    $fleetRepo = new AircraftRepository();
    $planes = $fleetRepo->getAllAircrafts(); 
    echo $this->twig->render( 'fleet.html.twig', 
                [
                  'route' => 'fleet',
                  'planes' => $planes
                ]);
   }

   public function routes()
   { 
    echo $this->twig->render('routes.html.twig', ['route' => 'routes']);
   }

   public function customers()
   { 
    echo $this->twig->render('customers.html.twig', ['route' => 'customers']);
   }
   public function addPlane()
   {
    $planesRepo = new AeroplaneRepository($this->conn);
    $planes = $planesRepo->getAllPlaneModels();
    
    $form = new PlaneForm();
    echo $this->twig->render('add-plane.html.twig', ['form' => $form->getForm() ]);
   }

   public function editPlane(int $id)
   {
    $planesRepo = new AeroplaneRepository($this->conn);
    $plane = $planesRepo->getById($id, 'aircraft');
    $form = new PlaneForm();
   
    echo $this->twig->render('edit-plane.html.twig', ['form' => $form->getForm($plane[0]) ]);
   }
   


   
   public function addAeroplane()
   {
    $plane = new AeroplaneEntity();
    $plane->setVendor('vendor');
    $plane->setModel('modelik');
    $plane->setPayload(2312);
    $this->db->persist(new AeroplaneRepository(), $plane);
   }

   
}