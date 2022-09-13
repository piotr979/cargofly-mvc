<?php

declare(strict_types = 1);

namespace App\Fixtures;

use App\Models\Database\PDOClient;
use App\Models\Entities\AeroplaneEntity;
use App\Models\Repositories\AeroplaneRepository;

class AeroplaneFixture extends AbstractFixture
{
    public function __construct($conn)
    {
        parent::__construct($conn);

        $aeroplanes = [
                [
                    'vendor' => 'Airbus',
                    'photo' => 'Airbus A-330.jpg',
                    'model' => 'A-330',
                    'payload' => 70
                ],
                [
                    'vendor' => 'Antonov',
                    'photo' => 'Anotonov An-32.jpg',
                    'model' => 'An-32',
                    'payload' => 28
                ],  
                [
                    'vendor' => 'Boeing',
                    'photo' => 'Boeing 777.jpg',
                    'model' => '777',
                    'payload' => 50
                ],
                [
                    'vendor' => 'Boeing',
                    'photo' => 'Boeing C-40.jpg',
                    'model' => 'C-40',
                    'payload' => 30
                ],  
                [
                    'vendor' => 'CanAir',
                    'photo' => 'CanAir CL-44.jpg',
                    'model' => 'CL-44',
                    'payload' => 70
                ],
                [
                    'vendor' => 'Casa',
                    'photo' => 'Casa CN-235.jpg',
                    'model' => 'CN-235',
                    'payload' => 25
                ],
                [
                    'vendor' => 'Cessna',
                    'photo' => 'Cessna 150.jpg',
                    'model' => '150',
                    'payload' => 1
                ],
                [
                    'vendor' => 'Cessna',
                    'photo' => 'Cessna 206.jpg',
                    'model' => '206',
                    'payload' => 2
                ]
            ];

        foreach ($aeroplanes as $aPlane => $data) {
            $plane = $this->makeNewAeroplane(
                vendor: $data['vendor'],
                photo: $data['photo'],
                model: $data['model'],
                payload: $data['payload']
            );
           $aeroplaneRepo = new AeroplaneRepository();
           $aeroplaneRepo->persist($plane);
        }
      
    }
    
    public function makeNewAeroplane(
                        string $vendor, 
                        string $photo, 
                        string $model,
                        int $payload): AeroplaneEntity
    {
        $plane = new AeroplaneEntity();
        $plane->setVendor($vendor);  
        $plane->setPhoto($photo);
        $plane->setModel($model);
        $plane->setPayload($payload);
        $plane->setDistance(0);
        return $plane;
    }
}