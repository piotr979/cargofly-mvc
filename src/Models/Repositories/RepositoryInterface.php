<?php

declare(strict_types = 1);

namespace App\Models\Repositories;

use App\Models\Entities\EntityInterface;

interface RepositoryInterface
{
    public function getAll(string $tableName);
    public function getById(int $id, string $tableName);
    public function persist($entity);

}