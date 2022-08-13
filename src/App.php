<?php

declare(strict_types = 1);

namespace App;

use App\Controllers\AdminController;
use App\Controllers\MainController;
use App\Fixtures\UserFixture;
use App\Fixtures\FixtureLauncher;
use App\Forms\FormInputBuilder;
use App\Forms\InputTypes\TextType;
use App\Services\Router;
use App\Services\Request;
use App\Models\Database\PDOClient;
use App\Models\Repositories\UserRepository;
use App\Models\Entities\UserEntity;

class App 
{

    private Router $router;
    private Request $request;
    private PDOClient $db;
    public static App $app;
    public MainController $mainController;
    public AdminController $adminController;

    public function __construct()
    {
        self::$app = $this;
        $this->router = new Router();
        $this->request = new Request();
        $this->mainController = new MainController();
        $this->adminController = new AdminController();

      

    }
    public function run()
    {
        // all routes from controllers to be attached here
        // each controller has attachRoutes method which adds
        // routes to the router;

        $this->mainController->attachRoutes($this->router);
        $this->adminController->attachRoutes($this->router);
        $this->db = new PDOClient(DB_DRIVER, DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
        $this->db->connect();
       
        $user = new UserEntity($this->db->getConnection());
        $userRepo = new UserRepository($this->db->getConnection());

        /**
         * Fixtures to run
         */
        // Uncomment function below to run fixtures
        //$fixtureLauncher = new FixtureLauncher($this->db->getConnection());
        // Uncomment function above to run fixtures

        $formBuilder = new FormInputBuilder();
        $elements = [];
        $elements[] = $formBuilder
                ->add(
                    TextType::class, 
                    [
                    'placeholder' => 'Hodler',
                    'label' => 'This is label',
                    'labelCssClasses' => 'd-block',
                    'inputCssClasses' => 'd-block'
                    ]
                )
                ->add(
                    TextType::class, 
                    ['placeholder' => 'Butek',
                    'labelCssClasses' => 'd-block']
                )
                ->build();
                ;

        echo $elements[0][1]->getInput();
    }  
    public function resolve($url)
    {
        $routeWithParams = $this->request->makeRouteWithParamsFromUrl($url,
                $this->router->getRoutes());
        if ($routeWithParams === false) {
            echo "No route found!";
        } else {
        
        (isset($routeWithParams['params'])) ? $this->router->callRoute(
            $routeWithParams['route'],
            $routeWithParams['params'])
            :
            $this->router->callRoute(
                $routeWithParams['route']
            );
        }
    }

    
}