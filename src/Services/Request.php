<?php

declare(strict_types=1);

namespace App\Services;

class Request
{
    /**
     * Builds single route with params
     */
    public function makeRouteWithParamsFromUrl(string $url, array $allRoutes): bool|array
    {
        // at first route existence is checked 
        preg_match('/\/(?<route>[\-a-zA-Z]*)/', $url, $matches);

        // if route is blank it's automatically redirected to index
        // (or any other route you wish)
        if ($matches['route'] === '') {
            $matches['route'] = 'index';
        }

        // if route exists  check if has any params
        if (isset($allRoutes[$matches['route']])) {

            // check if route exists;
            $routeName = $matches['route'];
            $matchedRoute = $allRoutes[$routeName];
            $params = $matchedRoute['params'];

            $routeIntercepted['route'] = $routeName;
            
            // pregParams are route params extracted from url address
            $pregParams = '';
            if (count($params) > 0) {

                // now iterate over our $params and based on this
                // build the preg that will mach our url 
                // in another words our $url must mach $params

                foreach ($params as $key => $param) {
                    if ($key != array_key_last($params)) {
                        $pregParams .= "(?<{$param}>[a-zA-Z0-9_-]+)\/";
                    } else {
                        $pregParams .= "(?<{$param}>[a-zA-Z0-9_-]+)";
                    }
                }
                // compare our built route with existing 
                preg_match(
                    '/\/(?<route>[a-zA-Z0-9_-]*)\/' . $pregParams . '/',
                    $url,
                    $matchedUrlWithParams
                );

                // iterate $params once again, but this time
                // new array with key and value that matches route and 
                // function with parameters associated with it
                foreach ($params as $param) {
                    if (!(isset($matchedUrlWithParams[$param]))) {
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
}
