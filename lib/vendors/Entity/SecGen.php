<?php
namespace Entity;

use \OCFram\Entity;

/**
* La classe SecGen a pour but de modéliser le DRH et le sécrétaire général de l'application. Ils peuvent gérer les intervenants.
*/
class SecGen extends Respo
{

  /**
  * Le constructeur de Respo. Ses droits sont fixés à 4.
  *
  * @param array $donnees Les données qu'on veut mettre dans notre responsable qui gère les intervenants.
  */
  public function __construct(array $donnees = [])
  {
    parent::__construct($donnees);
    $this->setDroits(4);
  }

}
