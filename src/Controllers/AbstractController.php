<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Services\Router;
use App\Views\ViewRenderer;
use App\App;
use App\Models\Repositories\CargoRepository;
use App\Services\FlashMessenger;
use App\Services\OrdersManager;

abstract class AbstractController {
   
    protected $twig;
    protected $conn;
    protected $db;
    protected FlashMessenger $flashMessenger;
    protected int $awaitingOrders;
   // protected $conn;
    public ViewRenderer $viewRenderer;

    public function __construct()
    {
        /**
         * Project was migrated to twig, view renderer is not needed
         * anymore, however I left it here as it may be useful in the future.
         */
        //$this->viewRenderer = new ViewRenderer();
        $this->flashMessenger = new FlashMessenger();
        $this->db = App::$app->db;
        $this->conn = App::$app->conn;
        /**
         * configure Twig
         */

        $loader = new \Twig\Loader\FilesystemLoader( ROOT_DIR . '/templates');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => ROOT_DIR . '/temp',
            'auto_reload' => true,
        ]);

        // attach awaiting orders globally to every page
        $this->twig->addGlobal('awaitingOrders', OrdersManager::getAwaitingOrdersNumber($this->conn));
    }
    abstract protected function attachRoutes(Router $router);

}
