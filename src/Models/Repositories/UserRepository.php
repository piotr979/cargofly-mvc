<?php

declare(strict_types = 1 );

namespace App\Models\Repositories;

use App\Models\Repositories\AbstractRepository;

class UserRepository extends AbstractRepository
{
    public function __construct($conn)
    {
        parent::__construct($conn);
    }
}