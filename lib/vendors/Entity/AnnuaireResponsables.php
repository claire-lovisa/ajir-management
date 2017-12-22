<?php
namespace Entity;

/**
* La classe AnnuaireResponsables a pour but de modéliser les annuaires contenant des responsables de l'application.
*/
class AnnuaireResponsables extends Annuaire
{
  /**
  * Les responsables dans l'annuaire
  */
  protected $responsables;

  const RESPONSABLES_INVALIDE = 1;


  public function __construct($donnees) {
    $this->setResponsables($donnees);
  }

  /**
  * Indique si la la liste de responsables est valide (elle contient au moins un responsable) ou non.
  */
  public function isValid() {
    return !(empty($this->responsables));
  }

  /**
  * Fixe les responsables de l'annuaire.
  *
  * @param $responsables Les responsables à associer à l'annuaire
  */
  public function setResponsables($responsables) {
    if (!is_array($responsables) || empty($responsables))
    {
      $this->erreurs[] = self::RESPONSABLES_INVALIDE;
    }
    $this->responsables = $responsables;
  }

  /**
  * Renvoie la liste des responsables de l'annuaire.
  *
  * @return La liste des responsables de l'annuaire
  */
  public function responsables() {
    return $this->responsables;
  }


}
