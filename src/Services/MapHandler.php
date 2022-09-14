<?php

declare(strict_types = 1);

namespace App\Services;

/**
 * Main task is to manage locations on maps. 
 */
class MapHandler {

    /**
     * Converts mysql's Point to coordinates (latitude and longitude)
     */
    public static function PointToLocation($point): array
    {
        $coordinates = unpack('x/x/x/x/corder/Ltype/dlat/dlon', $point);
        if ($coordinates) {
            return ['lat' => $coordinates['lat'], 'lon' => $coordinates['lon']];
        } 
        return ['lat' => 0, 'lon' => 0];
    }
}