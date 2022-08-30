<?php

declare(strict_types = 1);

namespace App\Services;

use App\Controllers\MainController;
use App\Services\Request;
use Closure;
use App\App;
use App\Helpers\Url;
use App\Services\Authorisation;

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
        /**
         * Routing is temp variable to store route name
         */
        $routing = trim($routeName, '/');

        // adds new entry to routes
        // contains 'callback' and also 'params'
        $routeController = "App\Controllers\\" . $controller;
        $callback = Closure::fromCallable([new $routeController, $routeName]);
        $this->routes[$routing]['callback'] = $callback;
        $this->routes[$routing]['params'] = $params;
        $this->routes[$routing]['reqParams'] = 3;
        $this->routes[$routing]['optionalParams'] = 5;
    }

    /**
     * Calls the route
     * @param string $url Url which is used for route call
     */
    
    public function callRoute(string $url, array $params = [])
    {
      
        /**
         * Gets $route from routes array (based on $url)
         */
       $route = $this->routes[
        trim($url, '/')
        ];
         /** 
         * we need to check if user is logged in, otherwise 
         * user be redirected to login page
         */
     
      // For some reason double if must be used
      // two ifs combined were giving me an error
      if ($url !="loggingAction" ) {
        if (($url !='login') && !Authorisation::isUserLogged() ) {
            Url::redirect('/login');
         }
        }
    
      call_user_func_array($route['callback'], $params);
    }

    /**
     * Get all routes
     * @return all registered routes
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}