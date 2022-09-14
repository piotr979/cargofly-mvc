<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Forms\SettingsForm;
use App\Services\Router;
use App\Services\Settings;

class SettingsController extends AbstractController
{

    /**
     * Required function attaches all routes of the controller
     */
   public function attachRoutes(Router $router): void
   {
    $router->attachRoute('SettingsController', 'settings');
   }

   public function settings(): void
   {
    $data = $_GET;
      if (isset($data['currency'])) {
        Settings::setCurrencyIndex((int)$data['currency']);
      }
    $settingsForm = new SettingsForm();
    $settingsForm->setData();
    echo $this->twig->render('settings.html.twig', 
                ['route' => 'settings',
                 'form' => $settingsForm->getForm()
                ]);
   }
}