<?php

declare(strict_types = 1);

namespace App;

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\MainController;
use App\Controllers\SettingsController;
use App\Fixtures\UserFixture;
use App\Fixtures\FixtureLauncher;
use App\Forms\FormInputBuilder;
use App\Forms\InputTypes\TextType;
use App\Services\Router;
use App\Services\Request;
use App\Models\Database\PDOClient;
use App\Models\Repositories\UserRepository;
use App\Models\Entities\UserEntity;
use App\Services\SessionManager;
use App\Models\Database\Database;
use App\Services\Authorisation;
use App\Helpers\Url;

class App 
{

    public Router $router;
    private Request $request;
    private PDOClient $db;
    public $conn;
    private UserEntity $user;
    public static App $app;
    public MainController $mainController;
    public AdminController $adminController;
    public AuthController $authController;
    public SettingsController $settingsController;

    public function __construct()
    {
        $this->db = new PDOClient(DB_DRIVER, DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
        $this->db->connect();
        $this->conn = $this->db->getConnection();
        $this->router = new Router();
        $this->request = new Request();
        $this->mainController = new MainController();
        $this->adminController = new AdminController();
        $this->authController = new AuthController();
        $this->settingsController = new SettingsController();


        $this->user = new UserEntity();
      
        /**
         * For easier access in classes
         */
        self::$app = $this;

    }
    public function run()
    {
        // all routes from controllers to be attached here
        // each controller has attachRoutes method which adds
        // routes to the router;

        SessionManager::sessionStart();

        $this->mainController->attachRoutes($this->router);
        $this->adminController->attachRoutes($this->router);
        $this->authController->attachRoutes($this->router);
        $this->settingsController->attachRoutes($this->router);

        
       
        /**
         * Fixtures to run
         */
        // Uncomment function below to run fixtures
        //$fixtureLauncher = new FixtureLauncher($this->db->getConnection());
        // Uncomment function above to run fixtures

       
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