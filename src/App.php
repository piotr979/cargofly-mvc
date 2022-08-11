<?php

declare(strict_types = 1);

namespace App;

use App\Controllers\AdminController;
use App\Controllers\MainController;
use App\Services\Router;
use App\Services\Request;
class App 
{

    private Router $router;
    private Request $request;
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
    }
    public function resolve($url)
    {
        $routeWithParams = $this->request->makeRouteWithParamsFromUrl($url,
                $this->router->getRoutes());
        if ($routeWithParams === false) {
            echo "NO route found";
        } else {
        $this->router->callRoute( 
            $routeWithParams['route'],
            $routeWithParams['params']);
        }
    }
}