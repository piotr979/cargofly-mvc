<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Services\Router;
use App\Views\ViewRenderer;

abstract class AbstractController {
   
    protected $twig;

    public ViewRenderer $viewRenderer;

    function __construct()
    {
        $this->viewRenderer = new ViewRenderer();

        /**
         * configure Twig
         */
        $loader = new \Twig\Loader\FilesystemLoader( ROOT_DIR . '/templates');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => ROOT_DIR . '/temp',
            'auto_reload' => true
        ]);
    }
    abstract function attachRoutes(Router $router);
}
