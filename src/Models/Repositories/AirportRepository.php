<?php

declare(strict_types=1);

namespace App\Models\Repositories;

use App\Models\Entities\EntityInterface;
use App\Models\Repositories\AbstractRepository;

class AirportRepository extends AbstractRepository implements RepositoryInterface
{
    public function __construct()
    {
        parent::__construct('airport');
    }
    public function persist(EntityInterface $airport)
    {
        parent::persistTo(
            columns: [
                'vendor',
                'photo',
                'model',
                'payload'
            ],
            object: $airport);
    }
}
