<?php

declare(strict_types = 1);

namespace App\Models\Database;

interface DatabaseClientInterface 
{
    public function connect(): object;
    public function runQuery(string $query, array $params = []): array;
}