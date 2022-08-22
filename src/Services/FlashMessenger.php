<?php

declare(strict_types = 1 );

namespace App\Services;

class FlashMessenger
{
    private array $messages = [];

    public function __construct()
    {

    }
    public function add(string $text)
    {
       $this->messages[] = $text;
    }

}