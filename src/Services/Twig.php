<?php

declare(strict_types = 1);

namespace App\Services;

class Twig
{

    private object $conn;

    public function __construct(object $conn)
    {
        $this->conn = $conn;
    }
    public function launchTwig(): object
    {
        /**
         * configure Twig
         */

        $loader = new \Twig\Loader\FilesystemLoader( ROOT_DIR . '/templates');
        $twig = new \Twig\Environment($loader, [
            'cache' => ROOT_DIR . '/temp',
            'auto_reload' => true,
        ]);
        // attach awaiting orders globally to every page
        $twig->addGlobal('awaitingOrdersAmount', OrdersManager::getAwaitingOrdersNumber($this->conn));
        $twig->addGlobal('currency', Settings::getCurrencySymbol());
        return $twig;
    }
}