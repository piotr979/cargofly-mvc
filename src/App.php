<?php

declare(strict_types = 1);

namespace App;

use App\Controllers\MainController;
use App\Services\Router;
use App\Services\Request;
class App 
{

    private Router $router;
    private Request $request;
    public static App $app;
    public MainController $mainController;
    public function __construct()
    {
        self::$app = $this;
        $this->router = new Router();
        $this->request = new Request();
        $this->mainController = new MainController();
    }
    public function run()
    {
        $this->mainController->attachRoutes($this->router);
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