<?php
namespace Model;

use \OCFram\Manager;
use \Entity\News;

/**
 * La classe ConnexionManager permet de gérer la relation entre les connexions et la base de données.
 */
abstract class ConnexionManager extends Manager
{
  /**
   * Méthode renvoyant le nombre d'email identiques à celui passé en paramètre.
   *
   * @param $email L'email dont on veut avoir le nombre d'occurences dans la base de données.
   *
   * @return int
   */
  abstract public function countEmail($email);

  /**
   * Méthode renvoyant le mot de passe haché correspondant à un email donné.
   *
   * @param $email L'email dont on veut avoir le nombre d'occurences dans la base de données.
   *
   * @return int
   */
  abstract public function getMdpHache($email);

  /**
   * Méthode renvoyant le prenom correspondant à un email donné.
   *
   * @param $email L'email dont on veut avoir le nombre d'occurences dans la base de données.
   *
   * @return string
   */
  abstract public function getPrenom($email);

  /**
   * Méthode renvoyant les droits correspondants à un email donné.
   *
   * @param $email L'email dont on veut avoir les droits associés.
   *
   * @return int Les droits
   */
  abstract public function getDroits($email);

  /**
   * Méthode renvoyant la validité correspondant à un email donné.
   *
   * @param $email L'email dont on veut avoir la validité associée.
   *
   * @return La validité
   */
  abstract public function getEstValide($email);

}
