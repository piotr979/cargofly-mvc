<?php

declare(strict_types = 1 );

namespace App\Services;

class FlashMessenger
{
 
    public function __construct()
    {

    }
    public function add(string $text, string $key = '')
    {
       $this->messages[] = $text;
       $_SESSION['flashes'] = [$text];
    }
    public function getMessages()
    {
        if (isset($_SESSION['flashes'])) {
            $flashes = $_SESSION['flashes'];
            unset($_SESSION['flashes']);
            return $flashes;
        }
        return [];
       
    }

}