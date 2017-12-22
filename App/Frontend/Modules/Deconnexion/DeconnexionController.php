<?php
namespace App\Frontend\Modules\Deconnexion;

use \OCFram\BackController;
use \OCFram\HTTPRequest;

/**
* La classe DeconnexionController a pour but de gérer la déconnexion au site.
*/
class DeconnexionController extends BackController
{
  /**
   * Permet d'exécuter l'index de la déconnexion.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Déconnexion');

    if ($this->app->user()->isAuthenticated()) {
      session_destroy();
      $this->app->httpResponse()->redirect('.');
    }
    else {
      $this->app->user()->setFlash('Vous ne pouvez pas vous déconnecter si vous n\'êtes pas connecté.');
      $this->app->httpResponse()->redirect('.');
    }

  }

}
