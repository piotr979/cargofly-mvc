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
   public function attachRoutes(Router $router)
   {

    // also all methods can be retrieved with ReflectionClass
    // TO BE DONE
    $router->attachRoute('ActionsController', 'removeAction', ['id', 'entity']);
   }

   public function removeAction(int $id, string $entity)
   {
    $repositoryName = "\App\Models\Repositories\\" . ucfirst($entity) . "Repository";
    $repo = new $repositoryName();

    if ($repo->remove($id)) {
        $this->flashMessenger->add('Item removed successfully');
        Url::redirect('/fleet/1/aircraft_name/asc/noString/noColumn');
    } else {
      $this->flashMessenger->add('Ups! Something wrong!');
    };
   }
}