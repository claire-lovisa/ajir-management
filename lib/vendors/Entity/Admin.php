<?php
namespace Entity;

use \OCFram\Entity;

/**
* La classe Admin a pour but de modéliser les administrateurs de l'application.
*/
class Admin extends RespoGereEtude
{

  /**
  * Le constructeur de Admin. Ses droits sont fixés à 5.
  *
  * @param array $donnees Les données qu'on veut mettre dans notre administrateur.
  */
  public function __construct(array $donnees = [])
  {
    parent::__construct($donnees);
    $this->setDroits(5);
  }

}
