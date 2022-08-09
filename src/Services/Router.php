<?php

declare(strict_types = 1);

namespace App\Services;

use App\Controllers\MainController;
use App\Services\Request;
use Closure;

/** 
 * This class manages routes. Core class
 */
class Router
{
    private Request $request;

    /**
     * $routes keeps all routes as array
     */
    private array $routes;

    public function __construct()
    {
        $this->request = new Request();

    }

    /**
     * Adds new route to route collection
     * @param string $controller Controller name 
     * @param string $routeName Name of the new route (also function from $controller) 
     */
    public function attachRoute(
        string $controller, 
        string $routeName, 
        array $params = []
        )
    {
        $this->setRoute($controller, $routeName, $params);
    }

    /** 
     * Set route. Builds up the routes (array) where each entry is a callback
     * containg: ['routeName'] = $callback, $params 
     * @param string $controller Controller name
     * @param string $route name (also function from $controller)
     * @param array $params optional array of parameters
     */
    private function setRoute
            (
            string $controller,
            string $routeName,
            array $params = []
            )
    {
       
        $routing = trim($routeName, '/');

        // adds new entry to routes
        // contains 'callback' and also 'params'
        $callback = Closure::fromCallable([new MainController, $routeName]);
        $this->routes[$routing]['callback'] = $callback;
       // var_dump($this->routes);
    }

    /**
     * Calls the route
     * @param string $url Url which is used for route call
     */
    
    public function callRoute(string $url, array $params = [])
    {
       $route = $this->routes[
        trim($url, '/')
        ];
       var_dump($route);
      call_user_func_array($route['callback'], [123]);
    }
}