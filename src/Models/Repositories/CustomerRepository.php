<?php

declare(strict_types=1);

namespace App\Models\Repositories;

use App\Models\Database\QueryBuilder;
use App\Models\Entities\AircraftEntity;
use App\Models\Entities\CargoEntity;
use App\Models\Entities\EntityInterface;
use App\Models\Repositories\AbstractRepository;
use DateTime;
use PDO;

class CustomerRepository extends AbstractRepository implements RepositoryInterface
{

    public function __construct()
    {
        parent::__construct('customer');
    }
    public function getAllPaginated(int $page, string $sortBy, string $sortOrder = 'asc', string $searchString = '', string $searchColumn = '')
    {
        $offset = ($page - 1) * 10;
        $query = $this->qb
            ->select('*')
            ->from($this->entityName)
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
    public function persist(EntityInterface $customer)
    {
        parent::persistTo(
            columns: [
                "customer_name", 
                "owner_fname", 
                "owner_lname", 
                "street1", 
                "street2",
                "city",
                "zip_code",
                "country",
                "vat",
                "logo"
            ], 
           object: $customer);
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
    public function countSingleCustomerOrdersWithDetails()
    {
        /** SELECT SUM(cargo.value) AS value_total,
         *  COUNT(cargo.id) AS orders_total FROM `customer` 
         * LEFT JOIN customer_cargos ON customer.id = customer_cargos.customer_id 
         * LEFT JOIN cargo ON customer_cargos.id = cargo.id 
         * WHERE customer.id = 1; 
         */
        $query = $this->qb
                ->select('SUM(cargo.value) AS value_total, COUNT(cargo.id) AS orders_total')
                ->from('customer')
                ->leftJoin('customer_cargos', 'customer.id', 'customer_cargos.customer_id')
                ->leftJoin('cargo', 'customer_cargos.id', 'cargo.id')
                ->where('customer.id', '3')
                ->getQuery();
       // dump($query);exit;
        return $this->db->runQuery($query);
    }
    public function getTopCustomers(int $limit)
    {
        /**
         * SELECT customer.id, COUNT(customer_cargos.id) AS orders_total FROM customer 
         *LEFT JOIN customer_cargos ON customer.id = customer_cargos.customer_id 
         *LEFT JOIN cargo ON customer_cargos.id = cargo.id GROUP BY customer.id DESC;
         */
        $query = $this->qb
        ->select('customer.id, COUNT(customer_cargos.id) AS orders_total, 
                customer_name, CONCAT( FORMAT(SUM(cargo.value),2)) AS value, customer.logo')
        ->from('customer')
        ->leftJoin('customer_cargos', 'customer.id', 'customer_cargos.customer_id')
        ->leftJoin('cargo', 'customer_cargos.id', 'cargo.id')
        ->groupBy('customer.id DESC')
        ->limitWithOffset(limit: $limit, offset: 0)
        ->getQuery();
        return $this->db->runQuery($query);
    }
    public function getCustomersMonthlyByDate()
    {
        $data = [];
        /**
         * SELECT COUNT(cargo.status) AS orders_delivered,delivery_time, 
         * date_created FROM cargo WHERE status = '2' 
         * GROUP BY date_created, delivery_time; 
         */
        $query = $this->qb
                ->select('MONTH(date_created) AS months, COUNT(*) AS amounts')
                ->from('customer')
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
        }
        return ($data);
    }
}
