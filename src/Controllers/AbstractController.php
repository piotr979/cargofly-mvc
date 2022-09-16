<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Services\Router;
use App\Views\ViewRenderer;
use App\App;
use App\Services\FlashMessenger;
use App\Services\Twig;
abstract class AbstractController {
   
    protected $twig;
    protected $conn;
    protected $db;
    protected FlashMessenger $flashMessenger;
    protected int $awaitingOrders;
    public ViewRenderer $viewRenderer;

    /**
     * Initialises FlashMessenger which is responsible for 
     * displaying messages after operations like entering/removing entries, etc.
     * Also launches twig
     */
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
        $this->twig = (new Twig($this->conn))->launchTwig();
    }
    
    abstract protected function attachRoutes(Router $router): void;
}
