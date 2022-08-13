<?php

declare(strict_type=1);

namespace App\Contracts;

interface FormBuilderInterface
{
    public function createForm(string $action, string $method);
}