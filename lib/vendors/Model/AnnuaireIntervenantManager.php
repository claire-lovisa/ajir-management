<?php
namespace Model;

use \OCFram\Manager;

/**
 * La classe AdminManager permet de gérer la relation entre les administrateurs et la base de données.
 */
abstract class AnnuaireIntervenantManager extends Manager
{

  public function saveCompetences($competences) {
    if (is_array($competences))
    {
      $this->modify($competences);
    }
    else
    {
      throw new \RuntimeException('Les compétences doivent être valides pour être enregistrées');
    }
  }

  abstract public function getCompetences();

  abstract protected function modify($competences);

}
