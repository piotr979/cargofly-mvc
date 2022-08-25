<?php

declare(strict_types = 1);

namespace App\Fixtures;

/** 
 * This fixture inserts list of countries from assets/countries.json file
 * Next the sql string is built and inserted into database
  */

class AirportFixture extends AbstractFixture
{
    public function __construct($conn)
    {
       parent::__construct($conn);
       $countriesJson = ROOT_DIR . "/public/assets/airports.json";
       $handle = fopen($countriesJson, 'r' );
       $countries = fread($handle, filesize($countriesJson));
       $cts = json_decode($countries, true);
      
       $values = '';
       foreach ($cts as $code => $airport) {

        $values .= "('" . 
        $airport['code'] . "', " . "'" .
        (str_replace("'", "\'", $airport['name'])) . "', " . "'" .
        (str_replace("'", "\'", $airport['city'])) . "', " . "'" .
        (str_replace("'", "\'", $airport['country'])) . "', " . 
        "POINT(" . $airport['lat'] . "," . $airport['lon'] . ")" . ", '"  .
        ($airport['elev'] ?? 0) 
        ;

        // add closing bracke and comma
        // but if the end of the JSON table add bracket only
        if ($code != array_key_last($cts)) {
            $values .= "'), ";
        } else {
            $values .= "')";
        }       
       }

       $sql = "INSERT INTO airport 
       ( code, airport_name, city, country, location, elevation ) VALUES " . $values;
       
       ;
       $this->runSql($sql);
    }
}
