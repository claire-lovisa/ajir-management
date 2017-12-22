<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Utilisateur;

/**
 * La classe UtilisateursManager permet de gérer la relation entre les utilisateurs et la base de données.
 */
abstract class UtilisateursManager extends Manager
{

  /**
   * Méthode permettant d'ajouter un utilisateur.
   * @param $utilisateur L'utilisateur à ajouter
   * @return void
   */
  abstract protected function add(Utilisateur $utilisateur);

  /**
   * Méthode permettant d'enregistrer un utilisateur.
   * @param $utilisateur L'utilisateur à enregistrer
   * @return void
   */
  public function save(Utilisateur $utilisateur)
  {
    if ($utilisateur->isValid())
    {
      $utilisateur->isNew() ? $this->add($utilisateur) : $this->modify($utilisateur);
    }
    else
    {
      throw new \RuntimeException('L\'utilisateur doit être valide pour être enregistrée');
    }
  }

  /**
   * Méthode permettant de compter les utilisateurs présents dans la base de données.
   * @return Le nombre d'utilisateurs
   */
  abstract public function count();

  /**
   * Méthode permettant de trouver le premier identifiant d'un utilisateur libre de la base de données.
   * @return Le premier identifiant libre
   */
  abstract public function getFreeID();

  /**
   * Méthode permettant de supprimer un utilisateur.
   * @param $id L'identifiant de l'utilisateur à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode permettant d'obtenir la liste des utilisateurs.
   * @param $debut L'indice du premier utilisateur à prendre
   * @param $limite Le nombre d'utilisateurs qu'on souhaite avoir dans la liste
   * @return La liste des utilisateurs
   */
  abstract public function getList($debut = -1, $limite = -1);

  /**
   * Méthode permettant d'obtenir la liste des utilisateurs non validés.
   * @return La liste des utilisateurs non validés
   */
  abstract public function getListNonValides();

  /**
   * Méthode permettant d'obtenir un utilisateur à partir de son identifiant.
   * @param $id L'identifiant de l'utilisateur qu'on souhaite récupérer
   * @return L'utilisateur qu'on récupère
   */
  abstract public function getUnique($id);

  /**
   * Méthode permettant de modifier un utilisateur.
   * @param $utilisateur L'utilisateur à modifier
   * @return void
   */
  abstract protected function modify(Utilisateur $utilisateur);

}
