<?php

declare(strict_types =1 );

namespace App\Views;
/**
 * This class is responsible for passing data to view
 * and display them on the screen
 * DEPRECATED
 */

class ViewRenderer
{
   
    /**
     * Builds view to be displayed. 
     * Can be used for injecting to base view or separately
     * @return view with params and data 
     */
    public function viewBuilder($view, $params = [], $data = [])
    {
        ob_start();
        $params = $params;
        $data = $data;
        include ROOT_DIR . "/templates/{$view}";
        return ob_get_clean();
    }
    /**
     * This method combines view with existing template (base)
     * @param $view view to be injected
     * @param $baseView base view 
     * @param $replacement string which is going to be replaced in baseView (for ex. {{ body }})
     */

    public function injectViewToBase($view, $baseView, $replacement)
    {
        $viewCombined = include ROOT_DIR . '/templates/{$baseView}';
       
    }
   

}