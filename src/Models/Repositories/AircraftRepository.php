<?php

declare(strict_types = 1 );

namespace App\Models\Repositories;

use App\Models\Repositories\AbstractRepository;
use App\Models\Entities\EntityInterface;
use DateTime;

class AircraftRepository 
            extends AbstractRepository 
            implements RepositoryInterface, SearchInterface
{
    public function __construct()
    {
        parent::__construct('aircraft');
    }
    public function getAllPaginated(int $page, string $sortBy, string $sortOrder = 'asc', string $searchString = '', string $searchColumn = '')
    {
        $offset = ($page - 1 ) * 10;
        $query = $this->qb
                ->select('aircraft.id, aircraft_name, hours_done, in_use, airport_base,
                vendor, model, payload, city')
                ->from('aircraft')
                ->leftJoin('aeroplane', 'aircraft.aeroplane', 'aeroplane.id')
                ->leftJoin('airport', 'aircraft.airport_base','airport.id')
                ->whereLike($searchColumn, $searchString)
                ->orderBy($sortBy, $sortOrder)
                ->limitWithOffset(limit: 10, offset: $offset)
                ->getQuery()
                ;
       return $this->db->runQuery($query);
    }
  /** 
     * Calls persistTo from parent class
     * @param $customer Any class compatible with EntityInterface
     */
    public function persist(EntityInterface $aircraft)
    {
        parent::persistTo(
            columns: [
                "aircraft_name", 
                "hours_done", 
                "in_use", 
                "airport_base", 
                "aeroplane"], 
           object: $aircraft);
    }
    /**
     * Counts pages. The problem was to get proper amount of entries
     * as when search form was submitted it had to be taken into account
     * otherwise it always returned full table with all entries
     */
    public function countPages(
                            int $limit, 
                            string $searchString = '',
                            string $searchColumn = ''): int
    {
        $query = $this->qb
                      ->select("COUNT(aircraft.id) AS count")
                      ->from('aircraft')
                      ->leftJoin('aeroplane', 'aircraft.aeroplane', 'aeroplane.id')
                      ->leftJoin('airport', 'aircraft.airport_base', 'airport.id')
                      ->whereLike($searchColumn, $searchString)
                      ->getQuery()
                      ;
        $result = $this->db->runQuery($query);
        $count = $result[0]['count'];
        return (int)ceil($count / $limit);
    }
   
    /** 
     * Saves to database
     * If id is different than 0 means it's editing existing entry
     */
   
    public function remove($id)
    {
        if ($this->removeById($id)) {
            return true;
        } else {
            return false;
        };
    }
    public function getPlanesMonthlyByDate()
    {
        $data = [];
        /**
         * SELECT COUNT(cargo.status) AS orders_delivered,delivery_time, 
         * date_created FROM cargo WHERE status = '2' 
         * GROUP BY date_created, delivery_time; 
         */
        $query = $this->qb
                ->select('MONTH(date_created) AS months, COUNT(*) AS amounts')
                ->from('aircraft')
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