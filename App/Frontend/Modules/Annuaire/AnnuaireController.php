<?php
namespace App\Frontend\Modules\Annuaire;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\AnnuaireResponsables;
use \Entity\AnnuaireIntervenants;
use \Entity\Intervenant;
/**
* La classe AnnuaireController a pour but de gérer l'accès aux annuaires.
*/
class AnnuaireController extends BackController
{
  use \OCFram\DataValidator;

  /**
   * Permet d'exécuter l'annuaire des responsables.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeResponsables(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Annuaire des responsables');

    // Si l'utilisateur est authentifié et qu'il a les droits suffisants, on accède à l'annuaire
    if ($this->app->user()->isAuthenticated()) {

      // On récupère la liste des responsables
      $manager = $this->managers->getManagerOf('Respos');
      $listeRespos = $manager->getList(0,$manager->count());
      $this->page->addVar('listeResposIni', $listeRespos);

      $annuaireResponsables = New AnnuaireResponsables([
            'responsables' => $listeRespos
          ]);

      // On regarde si l'utilisateur a voulu trier le tableau selon les différents critères
      if($request->getData('sort')==1) {
        usort($listeRespos, array($this,'comparerPrenoms'));
      }
      else if($request->getData('sort')==2) {
        usort($listeRespos, array($this,'comparerNoms'));
      }
      else if($request->getData('sort')==3) {
        usort($listeRespos, array($this,'comparerRangs'));
      }
      else if($request->getData('sort')==4) {
        usort($listeRespos, array($this,'comparerAnneesMandat'));
      }
      else if($request->getData('sort')==5) {
        usort($listeRespos, array($this,'comparerEmails'));
      }
      // Après avoir trié la liste selon la demande de l'utilisateur, on peut la renvoyer à la page
      $this->page->addVar('listeRespos', $listeRespos);

    }
    else {
      $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
      $this->app->httpResponse()->redirect('.');
    }
  }

  /**
   * Permet d'exécuter l'annuaire des intervenants.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeIntervenants(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Annuaire des intervenants');

    // Si l'utilisateur est authentifié et qu'il a les droits suffisants, on accède à l'annuaire
    if ($this->app->user()->isAuthenticated() AND ($this->app->user()->getAttribute('estValide')  == '1') AND ($this->app->user()->getAttribute('droits') !== null) AND $this->app->user()->getAttribute('droits')>=2) {

      // On récupère la liste des intervenants
      $manager = $this->managers->getManagerOf('Intervenants');
      $listeIntervenants = $manager->getList(0,$manager->count());
      $this->page->addVar('listeIntervenantsIni', $listeIntervenants);

      $toutesLesCompetences = $this->getListCompetences();
      $this->page->addVar('toutesLesCompetences', $toutesLesCompetences);

      $annuaireIntervenants = New AnnuaireIntervenants($listeIntervenants);

      // On regarde si l'utilisateur a voulu trier le tableau selon les différents critères
      if($request->getData('sort')==1) {
        usort($listeIntervenants, array($this,'comparerPrenoms'));
      }
      else if($request->getData('sort')==2) {
        usort($listeIntervenants, array($this,'comparerNoms'));
      }
      else if($request->getData('sort')==3) {
        usort($listeIntervenants, array($this,'comparerDepartements'));
      }
      else if($request->getData('sort')==4) {
        usort($listeIntervenants, array($this,'comparerCompetences'));
      }
      else if($request->getData('sort')==5) {
        usort($listeIntervenants, array($this,'comparerEmails'));
      }
      else if($request->getData('sort')==6) {
        usort($listeIntervenants, array($this,'comparerDatesFinAdhesion'));
      }
      // Après avoir trié la liste selon la demande de l'utilisateur, on peut la renvoyer à la page
      $this->page->addVar('listeIntervenants', $listeIntervenants);

      // Si l'utilisateur recherche un intervenant possédant des capacités particulières :
      if($request->postExists('recherche') AND !empty($request->postExists('competencesCherchees'))) {
        $this->page->addVar('competencesCherchees', $request->postData('competencesCherchees'));
      }

    }
    else {
      $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
      $this->app->httpResponse()->redirect('.');
    }
  }

  /**
   * Permet d'ajouter un intervenant à l'annuaire.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeAjouterIntervenant(HTTPRequest $request) {
    $this->page->addVar('title', 'Ajout d\'un intervenant');

    // Affichage des compétences selon les compétences présentes dans la base de données
    $manager = $this->managers->getManagerOf('Intervenants');
    $competences = $this->getListCompetences();
    $this->page->addVar('competences', $competences);

    // Si l'utilisateur est authentifié et qu'il a les droits suffisants, on accède à l'annuaire
    if ($this->app->user()->isAuthenticated() AND ($this->app->user()->getAttribute('estValide')  == '1') AND ($this->app->user()->getAttribute('droits') !== null) AND $this->app->user()->getAttribute('droits')>=4) {

        // On récupère les données de l'intervenant
        if($request->postExists('email') && $request->postExists('departement') && $request->postExists('prenom') && $request->postExists('nom') && $request->postExists('dateFinAdhesion')) {
          $prenom = $request->postData('prenom');
          $nom = $request->postData('nom');
          $email = $request->postData('email');
          $departement = $request->postData('departement');
          $dateFinAdhesion = $request->postData('dateFinAdhesion');
          $competences = $request->postData('competences');

          if(!$this->verificationEmailExiste($email,'Inscription')) {

          // On crée cet intervenant
          $intervenant = New Intervenant([
            'email' => $email,
            'nom' => $nom,
            'prenom' => $prenom,
            'departement' => $departement,
            'dateFinAdhesion' => $dateFinAdhesion,
            'competences' => $competences
          ]);

          // On l'ajoute aux intervenants
          $manager = $this->managers->getManagerOf('Intervenants')->save($intervenant);
          $this->app->httpResponse()->redirect('/annuaire-intervenants');
        }
        else {
          $this->app->user()->setFlash('Cet email existe déjà.');
        }
      }

    }
    else {
      $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
      $this->app->httpResponse()->redirect('.');
    }
  }

  /**
   * Permet de supprimer un intervenant à l'annuaire.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeSupprimerIntervenant(HTTPRequest $request) {
    $this->page->addVar('title', 'Suppression d\'un intervenant');

    // Si l'utilisateur est authentifié et qu'il a les droits suffisants, on accède à l'annuaire
    if ($this->app->user()->isAuthenticated() AND ($this->app->user()->getAttribute('estValide')  == '1') AND ($this->app->user()->getAttribute('droits') !== null) AND $this->app->user()->getAttribute('droits')>=4) {

      // On récupère l'email de l'intervenant et on le supprime
      if($request->postExists('email')) {
        $email = $request->postData('email');
        $manager = $this->managers->getManagerOf('Intervenants')->deleteFromEmail($email);
        $this->app->httpResponse()->redirect('/annuaire-intervenants');
      }

    }
    else {
      $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
      $this->app->httpResponse()->redirect('.');
    }
  }

  /**
   * Permet d'ajouter une compétence à l'annuaire.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeAjouterCompetence(HTTPRequest $request) {
    $this->page->addVar('title', 'Ajout d\'une compétence');

    // Si l'utilisateur est authentifié et qu'il a les droits suffisants, on accède à l'annuaire
    if ($this->app->user()->isAuthenticated() AND ($this->app->user()->getAttribute('estValide')  == '1') AND ($this->app->user()->getAttribute('droits') !== null) AND $this->app->user()->getAttribute('droits')>=4) {

      // On récupère la compétence à ajouter
      if($request->postExists('competence')) {
        $competence = strtolower($request->postData('competence'));

        // Si elle n'est pas déjà dans la liste ...
        if(!$this->existCompetence($competence))
        {
          // On l'ajoute à l'annuaire
          $managerIntervenants = $this->managers->getManagerOf('Intervenants');
          $listeIntervenants = $managerIntervenants->getList(0,$managerIntervenants->count());

          $AnnuaireIntervenants = new AnnuaireIntervenants($listeIntervenants,$this->getListCompetences());
          $AnnuaireIntervenants->ajouterCompetence($competence);

          // Et on enregistre la modification dans la base de données
          $managerAnnuaire = $this->managers->getManagerOf('AnnuaireIntervenant');
          $managerAnnuaire->saveCompetences($AnnuaireIntervenants->competencesPossibles());
          $this->app->httpResponse()->redirect('/annuaire-intervenants');
        }
        else {
          $this->app->user()->setFlash('La compétence existe déjà.');
        }
      }
    }
    else {
      $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
      $this->app->httpResponse()->redirect('.');
    }
  }

  /**
   * Permet de supprimer une compétence à l'annuaire.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeSupprimerCompetence(HTTPRequest $request) {
    $this->page->addVar('title', 'Suppression d\'une compétence');

    // Si l'utilisateur est authentifié et qu'il a les droits suffisants, on accède à l'annuaire
    if ($this->app->user()->isAuthenticated() AND ($this->app->user()->getAttribute('estValide') == '1') AND ($this->app->user()->getAttribute('droits') !== null) AND $this->app->user()->getAttribute('droits')>=4) {
      if($request->postExists('competence')) {
        // On récupère la compétence à supprimer
        $competence = strtolower($request->postData('competence'));

        // Si elle existe bien
        if($this->existCompetence($competence))
        {
          // On la supprime de l'annuaire
          $managerIntervenants = $this->managers->getManagerOf('Intervenants');
          $listeIntervenants = $managerIntervenants->getList(0,$managerIntervenants->count());

          $AnnuaireIntervenants = new AnnuaireIntervenants($listeIntervenants,$this->getListCompetences());
          $AnnuaireIntervenants->supprimerCompetence($competence);

          // Et on enregistre les modifications
          $managerAnnuaire = $this->managers->getManagerOf('AnnuaireIntervenant');
          $managerAnnuaire->saveCompetences($AnnuaireIntervenants->competencesPossibles());
          $this->app->httpResponse()->redirect('/annuaire-intervenants');
        }
        else {
          $this->app->user()->setFlash('La compétence n\'existe pas.');
        }
      }
    }
    else {
      $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
      $this->app->httpResponse()->redirect('.');
    }
  }

  private function existCompetence($competence) {
    $manager = $this->managers->getManagerOf('AnnuaireIntervenant');
    $competences = $manager->getCompetences();
    return(in_array($competence,$competences));
  }

  private function getListCompetences() {
    $manager = $this->managers->getManagerOf('AnnuaireIntervenant');
    $competences = $manager->getCompetences();
    return $competences;
  }

  private function comparerPrenoms($a, $b) {
    return strcmp($a->prenom(), $b->prenom());
  }

  private function comparerNoms($a, $b) {
    return strcmp($a->nom(), $b->nom());
  }

  private function comparerRangs($a, $b) {
    return strcmp($a->rang(), $b->rang());
  }

  private function comparerAnneesMandat($a, $b) {
    return strcmp($a->anneeMandat(), $b->anneeMandat());
  }

  private function comparerEmails($a, $b) {
    return strcmp($a->email(), $b->email());
  }

  private function comparerDepartements($a, $b) {
    return strcmp($a->departement(), $b->departement());
  }

  private function comparerCompetences($a, $b) {
    return strcmp(serialize($a->competences()), serialize($b->competences()));
  }

  private function comparerDatesFinAdhesion($a, $b) {
    return strcmp($a->dateFinAdhesion(), $b->dateFinAdhesion());
  }

}
