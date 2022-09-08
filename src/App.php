<?php

declare(strict_types=1);

namespace App;

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\MainController;
use App\Controllers\SettingsController;
use App\Controllers\ActionsController;
use App\Controllers\CargoController;
use App\Controllers\OrderController;
use App\Controllers\CustomerController;
use App\Controllers\FleetController;
use App\Controllers\NotFoundController;
use App\Services\Router;
use App\Services\Request;
use App\Models\Database\PDOClient;
use App\Models\Entities\UserEntity;
use App\Services\SessionManager;
use App\Services\FlashMessenger;
use Environment;

class App
{

    public Router $router;
    private Request $request;
    public PDOClient $db;
    public $conn;
    private array $config;
    public static App $app;
    public FlashMessenger $flashMessenger;

    public MainController $mainController;
    public AdminController $adminController;
    public AuthController $authController;
    public CustomerController $customerController;
    public CargoController $cargoController;
    public FleetController $fleetController;
    public SettingsController $settingsController;

    public function __construct(array $config)
    {
        $this->db = new PDOClient(DB_DRIVER, DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
        $this->db->connect();
        $this->conn = $this->db->getConnection();
        $this->config = $config;
        /**
         * For easier access in classes
         */
        self::$app = $this;
        $this->router = new Router();
        $this->request = new Request();
        $this->mainController = new MainController();
        $this->fleetController = new FleetController();
        $this->adminController = new AdminController();
        $this->authController = new AuthController();
        $this->customerController = new CustomerController();
        $this->cargoController = new CargoController();
        $this->settingsController = new SettingsController();
        $this->actionsController = new ActionsController();
        $this->notFoundController = new NotFoundController();

        $this->flashMessenger = new FlashMessenger();
        

        $this->user = new UserEntity();
    }
    public function run()
    {
        // all routes from controllers to be attached here
        // each controller has attachRoutes method which adds
        // routes to the router;

        SessionManager::sessionStart();

        // run this command below to do migrations
        //$migrations = new MigrationsManager();

        // command below drops all databases
        // $migrations->dropAllTables();

        // this command migrates the whole DB
        // $migrations->migrateDatabase();


        $this->mainController->attachRoutes($this->router);
        $this->adminController->attachRoutes($this->router);
        $this->authController->attachRoutes($this->router);
        $this->customerController->attachRoutes($this->router);
        $this->cargoController->attachRoutes($this->router);
        $this->fleetController->attachRoutes($this->router);
        $this->settingsController->attachRoutes($this->router);
        $this->actionsController->attachRoutes($this->router);
        $this->notFoundController->attachRoutes($this->router);



        /**
         * Fixtures to run
         */
        // Uncomment function below to run fixtures
        //$fixtureLauncher = new FixtureLauncher($this->conn);
        // Uncomment function above to run fixtures


    }
    public function resolve($url)
    {
        $routeWithParams = $this->request->makeRouteWithParamsFromUrl(
            $url,
            $this->router->getRoutes()
        );
        if ($routeWithParams === false) {
            $this->router->callRoute('pageNotFound', []);
        } else {
            (isset($routeWithParams['params'])) 
                ? 
                $this->router->callRoute(
                    $routeWithParams['route'],
                    $routeWithParams['params'])
                :
                $this->router->callRoute(
                    $routeWithParams['route']
                );
        }
    }
    public function isDebugMode(): bool
    {
     if ($this->config['environment'] === Environment::Dev) {  
      return true;
    }
      return false;
    }
}
