<?php

declare(strict_types = 1);

namespace App\Models\Repositories;

interface SearchInterface
{
    public function countPages(int $limit, string $searchString = '', string $searchColumn = ''): int;
    public function getAllPaginated(int $page, string $sortBy, string $sortOrder = 'asc', string $searchString = '', string $searchColumn = '');
}