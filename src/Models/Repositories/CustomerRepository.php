<?php

declare(strict_types=1);

namespace App\Models\Repositories;

use App\Models\Database\QueryBuilder;
use App\Models\Entities\AircraftEntity;
use App\Models\Entities\EntityInterface;
use App\Models\Repositories\AbstractRepository;
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
}
