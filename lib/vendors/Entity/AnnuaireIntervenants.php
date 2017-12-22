<?php
namespace Entity;

/**
* La classe AnnuaireIntervenants a pour but de modéliser les annuaires contenant des intervenants de l'application.
*/
class AnnuaireIntervenants extends Annuaire
{
  /**
  * Les responsables dans l'annuaire
  */
  protected $intervenants = [];

  /**
  * Les compétences que peut avoir un intervenant
  */
  protected $competencesPossibles = [];

  const INTERVENANTS_INVALIDE = 1;
  const COMPETENCESPOSSIBLES_INVALIDE = 2;
  const COMPETENCE_INVALIDE = 3;


  public function __construct($donnees = [], $competencesPossibles = []) {
    $this->setIntervenants($donnees);
    $this->setCompetencesPossibles($competencesPossibles);
  }

  /**
  * Indique si la la liste d'intervenants est valide (elle contient au moins un intervenant) ou non.
  */
  public function isValid() {
    return !(empty($this->intervenants));
  }

  /**
  * Fixe les intervenants à l'annuaire.
  *
  * @param $intervenants Les intervenants de l'annuaire
  */
  public function setIntervenants($intervenants) {
    if (!is_array($intervenants) || empty($intervenants))
    {
      $this->erreurs[] = self::INTERVENANTS_INVALIDE;
    }
    $this->intervenants = $intervenants;
  }

  /**
  * Fixe les compétences à l'annuaire.
  *
  * @param $competencesPossibles Les compétences de l'annuaire
  */
  public function setCompetencesPossibles($competencesPossibles) {
    if (!is_array($competencesPossibles) || empty($competencesPossibles))
    {
      $this->erreurs[] = self::COMPETENCESPOSSIBLES_INVALIDE;
    }
    $this->competencesPossibles = $competencesPossibles;
  }

  /**
  * Ajoute une compétence à l'annuaire.
  *
  * @param $competence La compétence à ajouter
  */
  public function ajouterCompetence($competence) {
    if (empty($competence))
    {
      $this->erreurs[] = self::COMPETENCE_INVALIDE;
    }

    $competencesPossibles = $this->competencesPossibles();
    $competencesPossibles[] = $competence;
    $this->setCompetencesPossibles($competencesPossibles);
  }

  /**
  * Supprime une compétence à l'annuaire.
  *
  * @param $competence La compétence à supprimer
  */
  public function supprimerCompetence($competence) {
    if (empty($competence))
    {
      $this->erreurs[] = self::COMPETENCE_INVALIDE;
    }

    $competencesPossibles = $this->competencesPossibles();
    unset($competencesPossibles[array_search($competence, $competencesPossibles)]);
    $this->setCompetencesPossibles($competencesPossibles);
  }

  /**
  * Renvoie la liste des compétences qu'il est possible d'avoir de l'annuaire.
  *
  * @return La liste des compétences qu'il est possible d'avoir de l'annuaire
  */
  public function intervenants() {
    return $this->intervenants;
  }

  /**
  * Renvoie la liste des compétences qu'il est possible d'avoir de l'annuaire.
  *
  * @return La liste des compétences qu'il est possible d'avoir de l'annuaire
  */
  public function competencesPossibles() {
    return $this->competencesPossibles;
  }


}
