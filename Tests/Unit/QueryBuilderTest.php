<?php

namespace Test\Units;

use PHPUnit\Framework\TestCase;
use App\Models\Database\QueryBuilder;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class QueryBuilderTest extends TestCase
{
    public function testQueryBuilderIfExists()
    {
        $qb = new QueryBuilder('customer');
        assertNotNull($qb);
    }

    // check if resuilt of query builder is expected
    public function testSelect()
    {
        $qb = new QueryBuilder('customer');
                $qb->select('all')
                    ->from('customer');

        assertEquals('SELECT ( all ) FROM customer', $qb->getQuery());
    }
    public function testInsert()
    {
        $qb = new QueryBuilder('customer');
        $qb->insert("customer");

        assertEquals('INSERT INTO customer', $qb->getQuery());
    }
}
