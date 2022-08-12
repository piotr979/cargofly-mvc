<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Services\Router;
use App\Views\ViewRenderer;

abstract class AbstractController {
   
    public ViewRenderer $viewRenderer;

    function __construct()
    {
        $this->viewRenderer = new ViewRenderer();
    }
    abstract function attachRoutes(Router $router);
}
