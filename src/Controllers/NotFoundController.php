<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Services\Router;

class NotFoundController extends AbstractController
{
    public function attachRoutes(Router $router): void
    {
        $router->attachRoute('NotFoundController', 'pageNotFound');
    }
    public function pageNotFound()
    {
        echo $this->twig->render('404.html.twig');
    }
}