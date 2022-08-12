<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Services\Router;
use App\Views\TemplateView;

abstract class AbstractController {
   
    public TemplateView $view;

    function __construct()
    {
        $this->view = new TemplateView();
    }
    abstract function attachRoutes(Router $router);
}
