<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Personne;

/**
 * La classe PersonnesManager permet de gérer la relation entre les personnes et la base de données.
 */
abstract class PersonnesManager extends Manager
{

  /**
   * Méthode permettant d'ajouter une personne.
   * @param $personne La personne à ajouter
   * @return void
   */
  abstract protected function add(Personne $personne);

  /**
   * Méthode permettant d'enregistrer une personne.
   * @param $personne La personne à enregistrer
   * @return void
   */
  public function save(Personne $personne)
  {
    if ($personne->isValid())
    {
      $personne->isNew() ? $this->add($personne) : $this->modify($personne);
    }
    else
    {
      throw new \RuntimeException('La personne doit être valide pour être enregistrée');
    }
  }

  /**
   * Méthode permettant de compter les personnes présentes dans la base de données.
   * @return Le nombre de personnes
   */
  abstract public function count();

  /**
   * Méthode permettant de trouver le premier identifiant d'une personne libre de la base de données.
   * @return Le premier identifiant libre
   */
  abstract public function getFreeID();

  /**
   * Méthode permettant de supprimer une personne.
   * @param $id L'identifiant de la personne à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode permettant d'obtenir la liste des personnes.
   * @param $debut L'indice de la première personne à prendre
   * @param $limite Le nombre de personnes qu'on souhaite avoir dans la liste
   * @return La liste de personnes
   */
  abstract public function getList($debut = -1, $limite = -1);

  /**
   * Méthode permettant de récupérer une personne à partir de son identifiant.
   * @param $id L'identifiant de la personne qu'on souhaite récupérer
   * @return La personne qu'on récupère
   */
  abstract public function getUnique($id);

  /**
   * Méthode permettant de modifier une personne.
   * @param $personne La personne à modifier
   * @return void
   */
  abstract protected function modify(Personne $personne);
}
