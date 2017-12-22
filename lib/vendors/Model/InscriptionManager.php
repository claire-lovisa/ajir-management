<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Inscription;

/**
 * La classe InscriptionManager permet de gérer la relation entre les inscriptions et la base de données.
 */
abstract class InscriptionManager extends Manager
{
  /**
   * Méthode renvoyant le nombre d'email identiques à celui passé en paramètre.
   *
   * @param $email L'email dont on veut avoir le nombre d'occurences dans la base de données.
   *
   * @return int
   */
    abstract public function countEmail($email);
}
