<?php
namespace App\Frontend\Modules\Accueil;

use \OCFram\BackController;
use \OCFram\HTTPRequest;

/**
* La classe AccueilController a pour but de gérer l'accès à l'accueil.
*/
class AccueilController extends BackController
{
  /**
   * Permet d'exécuter l'index de l'accueil.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeIndex(HTTPRequest $request)
  {
    // La variable 'accueil' permet d'indiquer au layout qu'on se trouve sur la page d'accueil.
    $this->page->addVar('accueil', 'ok');
    $this->page->addVar('title', 'Accueil de l\'espace membre');
  }

}
