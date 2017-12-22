<?php
namespace App\Frontend\Modules\Inscription;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Utilisateur;
use \Entity\Respo;
use \Entity\RespoGereEtude;
use \Entity\SecGen;
use \Entity\Admin;

/**
* La classe InscriptionController a pour but de gérer l'inscription au site.
*/
class InscriptionController extends BackController
{
  use \OCFram\DataValidator;

  /**
   * Permet d'exécuter l'index de l'inscription.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Inscription');

    // Si on a bien reçu toutes les variables du formulaire ...
    if ($request->postExists('email') && $request->postExists('mdp') && $request->postExists('prenom') && $request->postExists('nom') && $request->postExists('rang')) {

      // ... et si l'utilisateur n'est pas authentifié ...
      if (!$this->app->user()->isAuthenticated()) {

        // on récupère ses données
        $prenom = $request->postData('prenom');
        $nom = $request->postData('nom');
        $email = $request->postData('email');
        $rang = $request->postData('rang');

        // Si l'email n'est pas déjà enregistré ...
        if(!$this->verificationEmailExiste($email,'Inscription')) {

          // ... on vérifie que les deux mots de passe entrés sont identiques, et on en stocke le hash
          if(sha1($request->postData('mdp')) == sha1($request->postData('verifMdp'))) {
            $mdpHache = sha1($_POST['mdp']);
            $droits = $this->attributionDroits($rang);

            if($droits!=null) {

              $utilisateur = New Utilisateur([
                    'email' => $email,
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'mdpHache' => $mdpHache,
                    'estValide' => '0'
                  ]);

              // On enregistre l'utilisateur dans les bonnes tables, si il est respo ou non.
              $this->enregistrerDansBD($droits, $utilisateur, $rang);

            }
            else {
              $this->app->user()->setFlash('Merci de ne pas traffiquer mon formulaire !');
            }
          }
          else {
            $this->app->user()->setFlash('Les deux mots de passe sont différents.');
          }
        }
        else {
          $this->app->user()->setFlash('Cet email est déjà enregistré.');
        }

        $this->app->httpResponse()->redirect('.');
      }
      else {
        $this->app->user()->setFlash('Vous êtes connecté, pourquoi vous inscrire si vous avez déjà un compte ?');
        $this->app->httpResponse()->redirect('.');
      }

    }

  }


  /**
   * Permet d'exécuter l'index de l'inscription.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeAdministration(HTTPRequest $request) {
    $this->page->addVar('title', 'Administration');

    if ($this->app->user ()->isAuthenticated() AND ($this->app->user()->getAttribute('droits') !== null) AND $this->app->user()->getAttribute('droits')>=5) {
      $managerUtilisateur = $this->managers->getManagerOf('Utilisateurs');
      $utilisateursNonValides = $managerUtilisateur->getListNonValides();
      $this->page->addVar('utilisateursNonValides', $utilisateursNonValides);

      if($request->postExists('ok') AND $request->postExists('idUtilisateurAValider')){
        $utilisateur = $managerUtilisateur->getUnique($request->postData('idUtilisateurAValider'));
        $utilisateur->setEstValide(1);

        $managerUtilisateur->modify($utilisateur);
        $this->app->user()->setFlash('L\'utilisateur a reçu ses droits demandés.');
        $utilisateursNonValides = $managerUtilisateur->getListNonValides();
        $this->page->addVar('utilisateursNonValides', $utilisateursNonValides);
      }
      else if($request->postExists('ko') AND $request->postExists('idUtilisateurAValider')) {
        $utilisateur = $managerUtilisateur->getUnique($request->postData('idUtilisateurAValider'));
        $utilisateur->setEstValide(1);
        $utilisateur->setDroits(1);

        $managerUtilisateur->modify($utilisateur);
        $this->app->user()->setFlash('L\'utilisateur reste simplement membre actif.');
        $utilisateursNonValides = $managerUtilisateur->getListNonValides();
        $this->page->addVar('utilisateursNonValides', $utilisateursNonValides);
      }

    }
    else {
      $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
      $this->app->httpResponse()->redirect('.');
    }

  }


  /*
    * Cette fonction attribue automatiquement le niveau de droit correspondant au rang occupé à l'AJIR.
    * - Membre : 1
    * - Respo : 2
    * - Respo qui gère les études (respo Etudes, respo DevCo, vice-président, président) : 3
    * - Secrétaire général et directeur des ressources humaines : 4
    * - Admin : 5 (attribué manuellement)
    *
    * @param $rang Le rang de la personne qui s'est inscrite
  */
  public function attributionDroits($rang) {
    switch ($rang) {
        case 'membre-actif':
            $droits = 1;
            break;
        case 'responsable-qualité':
        case 'trésorier':
        case 'vice-trésorier':
        case 'comptable':
        case 'responsable-communication':
            $droits = 2;
            break;
        case 'président':
        case 'vice-président':
        case 'responsable-études':
        case 'responsable-développement-commercial':
            $droits = 3;
            break;
        case 'secrétaire-général':
        case 'directeur-des-ressources-humaines':
          $droits = 4;
          break;
        case 'directeur-des-systèmes-d\'information':
          $droits = 5;
          break;
        default:
          $droits = null;
          break;
    }
    return $droits;
  }

  /*
    * Cette fonction enregistre l'utilisateur dans les tables qui lui correspondent, selon son rang.
    *
    * @param $rang Le rang de la personne qui s'est inscrite
  */
  public function enregistrerDansBD($droits, $utilisateur, $rang) {
    $date=date("Y");
    switch($droits) {
      case '1':
        $manager = $this->managers->getManagerOf('Utilisateurs')->save($utilisateur);
        break;
      case '2' :
        $respo = New Respo([
          'email' => $utilisateur->email(),
          'nom' => $utilisateur->nom(),
          'prenom' => $utilisateur->prenom(),
          'mdpHache' => $utilisateur->mdpHache(),
          'rang' => $rang,
          'anneeMandat' => $date,
          'estValide' => '0'
        ]);
       $manager = $this->managers->getManagerOf('Respos')->save($respo);
       break;
      case '3' :
        $respoGereEtude = New RespoGereEtude([
          'email' => $utilisateur->email(),
          'nom' => $utilisateur->nom(),
          'prenom' => $utilisateur->prenom(),
          'mdpHache' => $utilisateur->mdpHache(),
          'rang' => $rang,
          'anneeMandat' => $date,
          'estValide' => '0'
        ]);
       $manager = $this->managers->getManagerOf('RespoGereEtude')->save($respoGereEtude);
       break;
      case '4' :
        $secGen = New SecGen([
            'email' => $utilisateur->email(),
            'nom' => $utilisateur->nom(),
            'prenom' => $utilisateur->prenom(),
            'mdpHache' => $utilisateur->mdpHache(),
            'rang' => $rang,
            'anneeMandat' => $date,
            'estValide' => '0'
          ]);
        $manager = $this->managers->getManagerOf('SecGen')->save($secGen);
        break;
      case '5' :
        $admin = New Admin([
            'email' => $utilisateur->email(),
            'nom' => $utilisateur->nom(),
            'prenom' => $utilisateur->prenom(),
            'mdpHache' => $utilisateur->mdpHache(),
            'rang' => $rang,
            'anneeMandat' => $date,
            'estValide' => '0'
          ]);
        $manager = $this->managers->getManagerOf('Admin')->save($admin);
        break;
      default :
        $this->app->user()->setFlash('Erreur d\'enregistrement dans la base de données.');
        break;
    }

  }

}
