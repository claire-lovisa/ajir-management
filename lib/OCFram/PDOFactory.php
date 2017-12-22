<?php
namespace OCFram;

/**
* La classe PDOFactory a pour but de gérer la connexion à la base de données.
*/
class PDOFactory
{

  /**
   * Lance la connexion à la base de données en PDO, et retourne l'objet PDO représentant la base de données.
   *
   * @return $db L'objet PDO représentant la connexion à la base de données.
   */
  public static function getMysqlConnexion()
  {
    $db = new \PDO('mysql:host=localhost;dbname=AJIR', 'root', '');
    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    return $db;
  }
}
