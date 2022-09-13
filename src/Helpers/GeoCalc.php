<?php

namespace App\Helpers;


class GeoCalc
{
    /** Script taken from 
     * https://stackoverflow.com/q/18883601/1496972
     * It calculcates distance between two geolocations (straight line)
     */

    public static function calcCrow($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371; // km
        $dLat = self::toRad($lat2 - $lat1);
        $dLon = self::toRad($lon2 - $lon1);
        $lat1 = self::toRad($lat1);
        $lat2 = self::toRad($lat2);

        $a = sin($dLat / 2) * sin($dLat / 2) + sin($dLon / 2) * sin($dLon / 2) * cos($lat1) * cos($lat2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = $R * $c;
        return $d;
    }

    // Converts numeric degrees to radians
    private static function toRad($Value)
    {
        return $Value * pi() / 180;
    }
}
