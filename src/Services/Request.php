<?php

declare(strict_types = 1);

namespace App\Services;

use Closure;

class Request
{
    public function getFullPathWithParams($path)
    {
        echo $path;
    }
    public function getRoute(array $routes, string $url)
    {
        // extract the route name
        
       
    }
    public function getParams(string $url)
    {

    }
    public function makeRouteWithParamsFromUrl(string $url, array $allRoutes)
    {
        // 1. Check if route name exist
        // 2. if it does, get how many parameters are required
        // 3. build the preg_match pattern
        // 4. compare against existing url
        // 5. use it

        $pregString = '/\/(?<route>[a-zA-Z0-9]*)\/';

        // at first route existence is checked 
        preg_match('/\/(?<route>[a-zA-Z]*)/', $url, $matches);

        // if route exsists  check if has any params
        if (isset($allRoutes[$matches['route']])) {
           
            // check if route exists;
            
            $value = $allRoutes[$matches['route']];
            dump($value);exit;
            $params = $value['params'];

            $pregParams = '';

            // now iterate over our $params and based on this
            // build the preg that will mach our url 
            // in another world our $url must mach $params
             foreach($params as $key => $param) {
                   if ($key != array_key_last($params)) {
                  
                    $pregParams .= "(?<{$param}>[a-zA-Z0-9]+)\/";
                } else {
                    $pregParams .= "(?<{$param}>[a-zA-Z0-9]+)";
                }
           
             }
           preg_match(
                '/\/(?<route>[a-zA-Z0-9]*)\/' . $pregParams . '/', 
                    $url, 
                    $matchedUrlWithParams
                );

                // iterate $params once again, but this time
                // new array with key and value that matches route and 
                // function with parameters associated with it
                foreach($params as $param) {
                
                    $paramsForRouteOnly[$param] = $matchedUrlWithParams[$param];
                }
               
                // now it's time to combine route name with params
                // and return them
                $routeWithParams = [];
                $routeWithParams['route'] = $matchedUrlWithParams['route'];
                $routeWithParams['params'] = $paramsForRouteOnly;
                return $routeWithParams;
        } else {
            return false;
        }
    }
}