<?php

declare(strict_types=1);

namespace App\Services;

use App\Forms\SearchColumnForm;
use App\Models\Repositories\SearchInterface;


/**
 * Search form processing.
 */
class SearchInquirer
{

    /**
     * Launches search engine (if needed)
     * Otherwise data are fetched without search string/column set
     * @param array $data $_GET data 
     * @param int page Page to fetch
     * @param SearchInterface $repository Object which conform with SearchInterface
     * @param SearchColumnForm $searchForm search form where data will be filled again
     * @param string $sortBy keyword which is used for sorting
     * @param string $sortOrder sort direction
     */

    public function processSearchWithPagination(
        array $data,
        int $page,
        SearchInterface $repository,
        SearchColumnForm $searchForm,
        string $sortBy,
        string $sortOrder = 'asc'
    ) : array
    {
        if (isset($data['searchString']) && isset($data['column'])) {
            $searchString = $_GET['searchString'];
            $searchColumn = $_GET['column'];
            $results = $repository->getAllPaginated(
                page: $page,
                sortBy: $sortBy,
                sortOrder: $sortOrder,
                searchString: $searchString,
                searchColumn: $searchColumn
            );
            $pages = $repository->countPages(
                limit: 10,
                searchString: $searchString,
                searchColumn: $searchColumn
            );
            //prepares Data for search Form (if entered already)
            
            $searchForm->setData(
                [
                    'searchString' => $searchString,
                    'searchColumn' => $searchColumn
                ]
            );
            return array(
                'results' => $results, 
                'pages' => $pages,
                'searchString' => $searchString,
                'searchColumn' => $searchColumn
                );

        } else {

            $results = $repository->getAllPaginated(
                page: $page,
                sortBy: $sortBy,
                sortOrder: $sortOrder
            );
         
            $pages = $repository->countPages(
                limit: 10
            );

            return array(
                'results' => $results, 
                'pages' => $pages
                );
        }
    }
}
