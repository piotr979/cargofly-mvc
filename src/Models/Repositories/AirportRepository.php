<?php

declare(strict_types=1);

namespace App\Models\Repositories;

use App\Helpers\Url;
use App\Models\Repositories\AbstractRepository;
use PDO;

class AirportRepository extends AbstractRepository implements RepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getAllAirports()
    {

        $stmt = $this->conn->prepare('SELECT * FROM airport');
        $stmt->setFetchMode(PDO::FETCH_CLASS, '\App\Models\Entities\AirportEntity');
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function persist($plane)
    {
        $mysql = "
            INSERT INTO aeroplane
                ( vendor, photo, model, payload) 
                VALUES
                ( :vendor, :photo, :model, :payload )
                ";
        $stmt = $this->conn->prepare($mysql);
        $stmt->bindValue(":vendor", $plane->getVendor(), PDO::PARAM_STR);
        $stmt->bindValue(":photo", $plane->getPhoto(), PDO::PARAM_STR);
        $stmt->bindValue(":model", $plane->getModel(), PDO::PARAM_STR);
        $stmt->bindValue(":payload", $plane->getPayload(), PDO::PARAM_STR);

        $stmt->execute();
    }
    public function countPages(
        int $limit,
        string $searchString = '',
        string $searchColumn = ''
    ): int {
        $searchStr = "'%" . $searchString . "%'";
        $sql = "SELECT COUNT(airport.id) AS count FROM airport";
        if ($searchColumn != '') {
            $sql .= ' WHERE ' . $searchColumn . ' LIKE ' . $searchStr;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $entries = $stmt->fetch()['count'];

        // now divide entries by given limit per page,
        // round it up and cast to int
        return (int)ceil($entries / $limit);
    }

    public function remove($id)
    {
        $mysql = "DELETE FROM airport WHERE id = :id";
        $stmt = $this->conn->prepare($mysql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $this->flashMessenger->add('Item removed.');
            Url::redirect('/dashboard');
        } else {
            $this->flasMessenger->add('Something wrong. Operation terminated.');
        };
    }
}
