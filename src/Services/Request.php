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
}