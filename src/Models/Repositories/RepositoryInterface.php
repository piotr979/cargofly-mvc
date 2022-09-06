<?php

declare(strict_types = 1);

namespace App\Models\Repositories;

use App\Models\Entities\EntityInterface;

interface RepositoryInterface
{
    public function getAll();
    public function getById(int $id);
    public function persist(EntityInterface $object);
}