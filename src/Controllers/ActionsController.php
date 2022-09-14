<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Helpers\Url;
use App\Services\Router;

class ActionsController extends AbstractController
{

    /**
     * Required function attaches all routes of the controller
     */
   public function attachRoutes(Router $router): void
   {
    $router->attachRoute('ActionsController', 'removeAction', ['id', 'entity']);
   }

   /**
    * Deletes selected entity 
    * @param int $id Id of the item
    * @param string $entity Entity name. Must end with "Repository" keyword.
    */
   public function removeAction(int $id, string $entity): void
   {
    $repositoryName = "\App\Models\Repositories\\" . ucfirst($entity) . "Repository";
    $repo = new $repositoryName();

    if ($repo->remove($id)) {
        $this->flashMessenger->add('Item removed successfully');
        Url::redirect('/orders/1/id/asc');
    } else {
      $this->flashMessenger->add('Ups! Something wrong!');
    };
   }
}