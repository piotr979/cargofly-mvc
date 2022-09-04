<?php

declare(strict_types = 1);

namespace App\Models\Repositories;

use App\Models\Entities\EntityInterface;

interface RepositoryInterface
{
    public function getAll();
    public function getById(int $id, string $tableName, string $entityName);
    public function persist($entity);
    public function countPages(int $limit, string $searchString, string $searchColumn): int;
}