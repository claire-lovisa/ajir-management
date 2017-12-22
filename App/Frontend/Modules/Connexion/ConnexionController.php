<?php
namespace App\Frontend\Modules\Connexion;

use \OCFram\BackController;
use \OCFram\HTTPRequest;

/**
* La classe AnnuaireController a pour but de gérer la connexion au site.
*/
class ConnexionController extends BackController
{
  use \OCFram\DataValidator;

  /**
   * Permet d'exécuter l'index de la connexion.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Connexion');

    if ($request->postExists('email')) {
      $email = $request->postData('email');
      $passwordHache = sha1($request->postData('mdp'));

      if ($this->verificationEmailExiste($email,'Connexion')) {
        if ($this->verificationMdpCorrect($passwordHache,'Connexion',$email)) {
          $this->app->user()->setAuthenticated(true);
          $this->app->user()->setAttribute('prenom',$this->getPrenom($email));
          $this->app->user()->setAttribute('droits',$this->getDroits($email)); // Savoir les droits de l'utilisateur permet de gérer les droits d'accès aux différentes parties du site
          $this->app->user()->setAttribute('estValide',$this->getEstValide($email));
          $this->app->httpResponse()->redirect('.');
        }
        else {
          $this->app->user()->setFlash('Le mot de passe est incorrect.');
        }
      }
      else
      {
        $this->app->user()->setFlash('L\'email est incorrect.');
      }
    }

  }

  /**
   * Renvoie le prénom associé à un email donné.
   *
   * @param $email L'email correspondant au prénom cherché
  */
  private function getPrenom($email) {
    return $prenom = $this->managers->getManagerOf('Connexion')->getPrenom($email);
  }

  /**
   * Renvoie les droits associés à un email donné.
   *
   * @param $email L'email correspondant aux droits cherchés
  */
  private function getDroits($email) {
    return $droits = $this->managers->getManagerOf('Connexion')->getDroits($email);
  }

  /**
   * Renvoie si le compte a été validé ou non>
   *
   * @param $email L'email correspondant à la validation cherchée
  */
  private function getEstValide($email) {
    return $estValide = $this->managers->getManagerOf('Connexion')->getEstValide($email);
  }

}
