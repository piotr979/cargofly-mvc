<?php

declare(strict_types =1 );

namespace App\Views;
/**
 * This class is responsible for passing data to view
 * and display them on the screen
 */

class TemplateView
{
    public function renderView($view, $params = [], $data = [])
    {
        ob_start();
        $params = $params;
        $data = $data;
        include ROOT_DIR . "/templates/{$view}";
        return ob_get_clean();
    }
}