<?php

declare(strict_types = 1);

namespace App;

use App\Controllers\MainController;
use App\Services\Router;

class App 
{

    private Router $router;
    public static App $app;
    public MainController $mainController;
    public function __construct()
    {
        self::$app = $this;
        $this->router = new Router();
        $this->mainController = new MainController();
    }
    public function run()
    {
        $this->mainController->attachRoutes($this->router);
    }
    public function resolve($url)
    {
        $this->router->callRoute($url);
    }
}