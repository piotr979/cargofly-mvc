<?php

declare(strict_types=1);

namespace App\Models\Repositories;

use App\Models\Entities\CargoEntity;
use App\Models\Entities\EntityInterface;
use App\Models\Repositories\AbstractRepository;

class CargoRepository extends AbstractRepository implements RepositoryInterface
{

    public function __construct()
    {
        parent::__construct('cargo');
    }
    public function getAllPaginated(int $page, string $sortBy, string $sortOrder = 'asc', string $searchString = '', string $searchColumn = '')
    {
       // SELECT cargo.id, cargo.value, cargo.airport_from, cargo.airport_to, 
       // cargo.weight, cargo.size, cargo.time_taken, customer.customer_name 
       // FROM cargo 
       // INNER JOIN customer_cargos ON cargo.id = customer_cargos.cargo_id
       //  INNER JOIN customer ON customer.id = customer_cargos.customer_id; 
        $offset = ($page - 1) * 10;
        $query = $this->qb
            ->select('cargo.id, 
                    cargo.value, 
                    cargo.airport_from, 
                    cargo.airport_to,
                    cargo.weight,
                    cargo.size,
                    cargo.time_taken,
                    customer_cargos.customer_id,
                    customer_cargos.cargo_id,
                    customer.customer_name
                    ')
            ->from($this->entityName)
            ->leftJoin('customer_cargos','customer_cargos.cargo_id', 'cargo.id')
            ->leftJoin('customer','customer.id', 'customer_cargos.customer_id')
            ->whereLike($searchColumn, $searchString)
            ->orderBy($sortBy, $sortOrder)
            ->limitWithOffset(limit: 10, offset: $offset)
            ->getQuery();
            dump($this->db->runQuery($query));
        return $this->db->runQuery($query);
    }

    /** 
     * Calls persistTo from parent class
     * @param $customer Any class compatible with EntityInterface
     */
    public function persist(EntityInterface $cargo)
    {
        parent::persistTo(
            columns: [
              "value",
              "airport_from",
              "airport_to",
              "status",
              "weight",
              "size",
              "time_taken"
            ], 
           object: $cargo);
    }
    public function persistOrder(CargoEntity $cargo)
    {
        $query = $this->qb
                    ->insert('value, airport_from, airport_to, status, weight, size, time_taken',
                    [
                        $cargo->getValue(),
                        $cargo->getAirportFrom(),
                        $cargo->getAirportTo(),
                        $cargo->getStatus(),
                        $cargo->getWeight(),
                        $cargo->getSize(),
                        $cargo->getTimeTaken()
                    ], 'cargo')
                    ->getQuery();
        $lastId = $this->db->pushQuery($query);
        $queryJoin = $this->qb
                        ->insert('customer_id, cargo_id',
                        [
                            $cargo->getCustomer(),
                            $lastId
                        ],
                        'customer_cargos')
                        ->getQuery();           
        $this->db->pushQuery($queryJoin);
    }
    public function remove($id)
    {
        if ($this->removeById($id, $this->getEntityNameFromRepoName())) {
            return true;
        } else {
            return false;
        };
    }
    /**
     * Counts pages. The problem was to get proper amount of entries
     * as when search form was submitted it had to be taken into account
     * otherwise it always returned full table with all entries
     */

    public function countPages(
        int $limit,
        string $searchString = '',
        string $searchColumn = ''
    ): int {
        $query = $this->qb
            ->select("COUNT(customer.id) AS count")
            ->from('customer')
            ->whereLike($searchColumn, $searchString)
            ->getQuery();
        $result = $this->db->runQuery($query);
        $count = $result[0]['count'];
        return (int)ceil($count / $limit);
    }
}
