<?php

declare(strict_types = 1);

namespace App\Services;

class MapHandler {
    public static function PointToLocation($point): array
    {
        $coordinates = unpack('x/x/x/x/corder/Ltype/dlat/dlon', $point);
        $lat = $coordinates['lat'];
       
        return ['lat' => $coordinates['lat'], 'lon' => $coordinates['lon']];
    }
}