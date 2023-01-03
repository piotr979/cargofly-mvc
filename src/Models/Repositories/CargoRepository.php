<?php

declare(strict_types=1);

namespace App\Models\Repositories;

use App\Models\Entities\CargoEntity;
use App\Models\Entities\EntityInterface;
use App\Models\Repositories\AbstractRepository;
use DateTime;

class CargoRepository 
            extends AbstractRepository 
            implements RepositoryInterface, SearchInterface
{
    private $columns = ['value', 'city_from', 'city_to', 'weight', 'size', 'delivery_time'];
    public function __construct()
    {
        parent::__construct('cargo');
    }
    public function getAllPaginated(int $page, string $sortBy, string $sortOrder = 'asc', string $searchString = '', string $searchColumn = '')
    {
        // SELECT cargo.id, cargo.value, cargo.airport_from, cargo.airport_to, 
        // cargo.weight, cargo.size, cargo.delivery_time, customer.customer_name 
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
                    cargo.delivery_time,
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

    public function persist(EntityInterface $cargo)
    {
        $this->persistOrder($cargo);
    }
    /**
     * Persisting order requires unique method (different than persist
     * from AbstractController)
     */
    public function persistOrder(CargoEntity $cargo)
    {
        $values = [
            $cargo->getValue(),
            $cargo->getCityFrom(),
            $cargo->getCityTo(),
            $cargo->getWeight(),
            $cargo->getSize(),
            $cargo->getDeliveryTime()
        ];
        if ($cargo->getId() == 0) {
            $query = $this->qb
                ->insert($this->columns, $values, 'cargo')
                ->getQuery();
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
    public function setStatus(int $id, int $status): void
    {
        $query = $this->qb
                ->update(
                        tableName: $this->entityName,
                        args: ['status'],
                        values: [$status],
                        id: $id)
                ->getQuery();
        $this->db->pushQuery($query);
    }
    public function setDeliveryTime(int $id, int $time)
    {
        $query = $this->qb
        ->update(
                tableName: $this->entityName,
                args: ['delivery_time'],
                values: [$time],
                id: $id)
        ->getQuery();
        $this->db->pushQuery($query);
    }
    public function redirectDelivery(int $id, int $airportId): void
    {
        $query = $this->qb
                ->update(
                        tableName: $this->entityName,
                        args: ['city_to'],
                        values: [$airportId],
                        id: $id)
                ->getQuery();
        $this->db->pushQuery($query);
    }

    public function getSingleCargoById($id)
    {
        $query = $this->qb
            ->select('
        cargo.id, 
        cargo.value, 
        cargo.weight,
        cargo.size,
        cargo.delivery_time,
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
        $query = '';
        if ($searchColumn === '') {
        $query = $this->qb
            ->select("COUNT(cargo.id) AS count")
            ->from("cargo")
            ->getQuery();
        } else {
            $query = $this->qb
            ->select("COUNT(cargo.id) AS count, " . $searchColumn)
            ->from("cargo")
            ->leftJoin('customer_cargos', 'customer_cargos.cargo_id', 'cargo.id')
            ->leftJoin('customer', 'customer.id', 'customer_cargos.customer_id')
            ->leftJoin('airport AS air_from ', 'cargo.city_from', 'air_from.id')
            ->leftJoin('airport AS air_to ', 'cargo.city_to', 'air_to.id')
            ->whereLike($searchColumn, $searchString)
            ->groupBy($searchColumn)
            ->getQuery();
        }
        $result = $this->db->runQuery($query);
        $count = $result[0]['count'];
        return (int)ceil($count / $limit);
    }

    public function getAwaitingOrders(int $limit)
    {
        $query = $this->qb
            ->select('
        cargo.id, 
        cargo.value, 
        cargo.weight,
        cargo.size,
        cargo.delivery_time,
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
            ->limitWithOffset($limit)
            ->getQuery();
        return $this->db->runQuery($query);
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

    /** 
     * This function generates random orders  
     * */
    public function generateRandomOrders(int $ordersAmount)
    {
        for($i=0; $i<=$ordersAmount;$i++ ) {
            $order = new CargoEntity();
            $order->setValue(rand(500,15000));
            $order->setCityFrom(rand(1,38));
            $order->setCityTo(rand(1,38));
            $order->setStatus(rand(1,4));
            $order->setWeight(rand(500,1500));
            $order->setSize(rand(200,1500));
            $order->setCustomer(rand(1,4));
            $order->setDeliveryTime(rand(5,50));
            $this->persistOrder($order);
        }
    }
    /**
     * returns array of days and amount of cargos on those days
     */
    public function getDeliveredCargosByDate()
    {
        $data = [];
        $incomes = [];
        /**
         * SELECT COUNT(cargo.status) AS orders_delivered,delivery_time, 
         * date_created FROM cargo WHERE status = '2' 
         * GROUP BY date_created, delivery_time; 
         */
        $query = $this->qb
                ->select('MONTH(date_created) AS months, COUNT(*) AS amounts,  SUM(value) AS income')
                ->from('cargo')
                ->where('status', '2')
                ->groupBy('MONTH(date_created)')
                ->getQuery();
        
        $results = $this->db->runQuery($query);
        /**
         * https://stackoverflow.com/a/18467892/1496972
         */
        foreach ($results as $result) {
            $dateObj = DateTime::createFromFormat('!m', (string)$result['months']);
            $monthName = $dateObj->format('F');
            $data[$monthName] = $result['amounts'];
            $incomes[] = $result['income'];
        }
        return [$data, $incomes];
    }
}
