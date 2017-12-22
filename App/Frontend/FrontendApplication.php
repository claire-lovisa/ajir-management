<?php
namespace App\Frontend;

use \OCFram\Application;

/**
* La classe FrontendApplication a pour but de représenter le frontend de l'application.
* Elle gère toute la partie de l'application qui n'implique pas d'administrateur.
*/
class FrontendApplication extends Application
{

  /**
   * Le constructeur de FrontendApplication.
   */
  public function __construct()
  {
    parent::__construct();

    $this->name = 'Frontend';
  }

  /**
   * Exécute le contrôleur associé à l'application.
   */
  public function run()
  {
    $controller = $this->getController();
    $controller->execute();

    $this->httpResponse->setPage($controller->page());
    $this->httpResponse->send();
  }
}
