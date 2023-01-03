<?php

declare(strict_types=1);

namespace App;

use App\Services\Router;
use App\Services\Request;
use App\Models\Database\PDOClient;
use App\Models\Entities\UserEntity;
use App\Services\SessionManager;
use App\Services\FlashMessenger;
use Environment;
use App\Fixtures\FixtureLauncher;
class App
{
    public Router $router;
    private Request $request;
    public PDOClient $db;
    public $conn;
    private array $config;
    public static App $app;
    public FlashMessenger $flashMessenger;

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

        // call the function which install controllers dynamically
        $this->installControllersAndAttachRoutes();
       
        $this->flashMessenger = new FlashMessenger();
        $this->user = new UserEntity();
    }
    public function run()
    {
      //  set_exception_handler([new \App\Exceptions\ExceptionHandler, 'handle']);
        // Uncomment function below to run fixtures
        //$fixtureLauncher = new FixtureLauncher($this->conn);
        // Uncomment function above to run fixtures
        SessionManager::sessionStart();
    }

    /**
     * When new url is entered this function is triggered 
     * to process given url
     * @param string $url 
     */
    public function resolve($url): void
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

    /**
     * @return bool If true app is dev mode, production otherwise
     */
    public function isDebugMode(): bool
    {
     if ($this->config['environment'] === Environment::Dev) {  
      return true;
    }
      return false;
    }

    /**
     * This function creates controllers 
     * by scanning "Controllers" folder (except AbstractController)
     * more exclusions can be added
     * Also attaches routes
     */
    private function installControllersAndAttachRoutes(): void
    {
       
       $controllers = [];
       $allFiles = scandir(__DIR__ . "/Controllers");
       $files = array_diff($allFiles, array('.','..'));

       foreach ($files as $file) {
            if ($file == "AbstractController.php") {
                continue;
            }
        $controllers[] = str_replace(".php", '', $file);
       }
       foreach ($controllers as $controller) {
        $controllerObject = lcfirst($controller);
        $controllerWithNamespace = 'App\Controllers\\' . $controller;
        $this->{$controllerObject} = new $controllerWithNamespace();
        $this->{$controllerObject}->attachRoutes($this->router);
       }
    }
}
