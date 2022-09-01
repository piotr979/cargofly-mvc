<?php

declare(strict_types = 1);

namespace App\Services;

use Closure;
use ReflectionClass;

class Request
{
    const HOME = 10;
    public function getFullPathWithParams($path)
    {
        echo $path;
        echo self::HOME;
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

        // mam route ktory podaje ze mam 5 params
        // ale mam tylko 3
        // sprawdz czy moga byc 3 z reflectionClass
        // 
        // 1. Check if route name exist
        // 2. if it does, get how many parameters are required
        // 3. build the preg_match pattern
        // 4. compare against existing url
        // 5. use it

        // at first route existence is checked 
        preg_match('/\/(?<route>[\-a-zA-Z]*)/', $url, $matches);
        
        // if route is blank it's automatically redirected to index
        // (or any other route you wish)
        if ($matches['route'] === '') {
            $matches['route'] = 'index';
        }
        
      
        // if route exists  check if has any params
        if (isset($allRoutes[$matches['route']])) {

            // if route is blank redirect to index or another page
           
            // check if route exists;
            $routeName = $matches['route'];
            $matchedRoute = $allRoutes[$routeName];
            $params = $matchedRoute['params'];
            $pregParams = '';


            // params
          


            $routeIntercepted['route'] = $routeName;
            if (count($params) > 0) {

                  // now iterate over our $params and based on this
                  // build the preg that will mach our url 
                  // in another words our $url must mach $params

                // $ref = new \ReflectionMethod('App\Controllers\MainController', 'fleet');
                // $requiredParams = $ref->getNumberOfRequiredParameters();
                // $requiredAndOptionalParams = $ref->getNumberOfParameters();

                // params amount
              
                
                $requiredParams = $allRoutes[$routeName]['reqParams'];
                $optionalParams = $allRoutes[$routeName]['optionalParams'];

             
                foreach($params as $key => $param) {
                    if ($key != array_key_last($params)) {
                     $pregParams .= "(?<{$param}>[a-zA-Z0-9_-]+)\/";
                 } else {
                     $pregParams .= "(?<{$param}>[a-zA-Z0-9_-]+)";
                 }

              }
            
// now its time to compare our built route with
              // existing 
    
            preg_match(
                 '/\/(?<route>[a-zA-Z0-9_-]*)\/' . $pregParams . '/', 
                     $url, 
                     $matchedUrlWithParams
            );

              
                 // iterate $params once again, but this time
                 // new array with key and value that matches route and 
                 // function with parameters associated with it
                 foreach($params as $param) {
                    if ( !(isset($matchedUrlWithParams[$param]))) {
                        return false;
                    }
                     $paramsForRouteOnly[$param] = $matchedUrlWithParams[$param];
                 }
                
                 // now it's time to combine route name with params
                 // and return them
                
                 $routeIntercepted['params'] = $paramsForRouteOnly;
            }
          
            // if there are no params code below is run only    
            return $routeIntercepted;

        } else {
            return false;
        }
    }
    private function checkForRoute(int $paramsAmount, string $url, $params)
    {
        $pregParams = '';
        for ( $i=1; $i<= $paramsAmount-1; $i++) {
            $pregParams .= "(?<{$params[$i-1]}>[a-zA-Z0-9_-]+)\/";
        }
    
        $pregParams .= "(?<{$params[$paramsAmount-1]}>[a-zA-Z0-9_-]+)";
     

        $pregString = '/\/(?<route>[a-zA-Z0-9_-]+)\/' . $pregParams . '/';
   
        if (preg_match(
                $pregString, 
                $url, 
                $matchedUrlWithParams
            )) {
            } else {
            };
        
        foreach($params as $param) {
                if ( !(isset($matchedUrlWithParams[$param]))) {
                    return false;
                
                 $paramsForRouteOnly[$param] = $matchedUrlWithParams[$param];
             }
            
             // now it's time to combine route name with params
             // and return them
             $routeIntercepted['params'] = $paramsForRouteOnly;
            }
    }
}