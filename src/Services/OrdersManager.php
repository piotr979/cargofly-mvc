<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Repositories\CargoRepository;

/**
 * This class is for secondary cargo's (orders) operations 
 */

class OrdersManager
{

    public static function getAwaitingOrdersNumber(object $conn)
    {
        $cargoRepo = new CargoRepository();
        return $cargoRepo->getAwaitingOrdersNumber();
    }
}
