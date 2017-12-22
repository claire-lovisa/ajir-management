<?php
namespace Entity;

use \OCFram\Entity;

/**
* La classe RespoGereEtude a pour but de modéliser les responsables de pôle aptes à gérer les études de l'application.
*/
class RespoGereEtude extends Respo
{

  /**
  * Le constructeur de Respo. Ses droits sont fixés à 3.
  *
  * @param array $donnees Les données qu'on veut mettre dans notre responsable qui gère les études.
  */
  public function __construct(array $donnees = [])
  {
    parent::__construct($donnees);
    $this->setDroits(3);
  }

}
