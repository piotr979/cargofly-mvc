<?php

declare(strict_types=1);

namespace App\Models\Repositories;

use App\Models\Entities\CargoEntity;
use App\Models\Entities\EntityInterface;
use App\Models\Repositories\AbstractRepository;

class CargoRepository extends AbstractRepository implements RepositoryInterface
{
    private $columns = ['value', 'city_from', 'city_to', 'weight', 'size'];
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
            ->select('
                    cargo.id, 
                    cargo.value, 
                    cargo.weight,
                    cargo.size,
                    cargo.time_taken,
                    cargo.status,
                    customer_cargos.customer_id,
                    customer.customer_name,
                    air_from.city AS city_from,
                    air_to.city AS city_to
                    ')
            ->from($this->entityName)
            ->leftJoin('customer_cargos', 'customer_cargos.cargo_id', 'cargo.id')
            ->leftJoin('customer', 'customer.id', 'customer_cargos.customer_id')
            ->leftJoin('airport AS air_from ', 'cargo.city_from', 'air_from.id')
            ->leftJoin('airport AS air_to ', 'cargo.city_to', 'air_to.id')

            ->whereLike($searchColumn, $searchString)
            ->orderBy($sortBy, $sortOrder)
            ->limitWithOffset(limit: 10, offset: $offset)
            ->getQuery();
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
                "city_from",
                "city_to",
                "weight",
                "size"
            ],
            object: $cargo
        );
    }
    public function persistOrder(CargoEntity $cargo)
    {
        $values = [
            $cargo->getValue(),
            $cargo->getCityFrom(),
            $cargo->getCityTo(),
            $cargo->getWeight(),
            $cargo->getSize()
        ];
        if ($cargo->getId() == 0) {
            $query = $this->qb
                ->insert($this->columns, $values, 'cargo')
                ->getQuery();
            dump($query);
            $lastId = $this->db->pushQuery($query);
            $queryJoin = $this->qb
                ->insert(
                    'customer_id, cargo_id',
                    [
                        $cargo->getCustomer(),
                        $lastId
                    ],
                    'customer_cargos'
                )
                ->getQuery();
            $this->db->pushQuery($queryJoin);
        } else {
            $query = $this->qb
                ->update(
                    tableName: 'cargo',
                    args: $this->columns,
                    values: $values,
                    id: $cargo->getId()
                )
                ->getQuery();
            $this->db->pushQuery($query);
        }
    }
    public function remove($id)
    {
        if ($this->removeById($id, $this->getEntityNameFromRepoName())) {
            return true;
        } else {
            return false;
        };
    }
    public function getSingleCargoById($id)
    {
        $query = $this->qb
            ->select('
        cargo.id, 
        cargo.value, 
        cargo.weight,
        cargo.size,
        cargo.time_taken,
        cargo.status,
        customer_cargos.customer_id,
        customer.customer_name,
        air_from.city AS city_from,
        air_from.location AS location_origin,
        air_to.city AS city_to,
        air_to.location AS location_destination
        ')
            ->from($this->entityName)
            ->leftJoin('customer_cargos', 'customer_cargos.cargo_id', 'cargo.id')
            ->leftJoin('customer', 'customer.id', 'customer_cargos.customer_id')
            ->leftJoin('airport AS air_from ', 'cargo.city_from', 'air_from.id')
            ->leftJoin('airport AS air_to ', 'cargo.city_to', 'air_to.id')
            ->where("cargo.id", (string)$id)
            ->getQuery();
        return $this->db->runQuery($query, single: true);
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
            ->select("COUNT(cargo.id) AS count")
            ->from("cargo")
            ->whereLike($searchColumn, $searchString)
            ->getQuery();
        $result = $this->db->runQuery($query);
        $count = $result[0]['count'];
        return (int)ceil($count / $limit);
    }
    public function getAwaitingOrdersNumber()
    {
        $query = $this->qb
            ->select("COUNT(cargo.id) AS count")
            ->from("cargo")
            ->whereLike('status', "0")
            ->getQuery();
        return $this->db->runQuery($query)[0]['count'];
    }
}
