<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Respo;

/**
 * La classe ResposManager permet de gérer la relation entre les responsables et la base de données.
 */
abstract class ResposManager extends Manager
{

  /**
   * Méthode permettant d'ajouter un responsable.
   * @param $respo Le responsable à ajouter
   * @return void
   */
  abstract protected function add(Respo $respo);

  /**
   * Méthode permettant d'enregistrer un responsable.
   * @param $respo Le responsable à enregistrer
   * @return void
   */
  public function save(Respo $respo)
  {
    if ($respo->isValid())
    {
      $respo->isNew() ? $this->add($respo) : $this->modify($respo);
    }
    else
    {
      throw new \RuntimeException('Le responsable doit être valide pour être enregistré');
    }
  }

  /**
   * Méthode permettant de compter les responsables présents dans la base de données.
   * @return Le nombre de responsables
   */
  abstract public function count();

  /**
   * Méthode permettant de trouver le premier identifiant d'un responsable libre de la base de données.
   * @return Le premier identifiant libre
   */
  abstract public function getFreeID();

  /**
   * Méthode permettant de supprimer un responsable.
   * @param $id L'identifiant du responsable à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode permettant d'obtenir la liste des responsables.
   * @param $debut L'indice du premier responsable à prendre
   * @param $limite Le nombre de responsables qu'on souhaite avoir dans la liste
   * @return La liste de responsables
   */
  abstract public function getList($debut = -1, $limite = -1);

  /**
   * Méthode permettant d'obtenir un responsable à partir de son identifiant.
   * @param $id L'identifiant du responsable qu'on souhaite récupérer
   * @return Le responsable qu'on récupère
   */
  abstract public function getUnique($id);

  /**
   * Méthode permettant de modifier un responsable.
   * @param $respo Le responsable à modifier
   * @return void
   */
  abstract protected function modify(Respo $respo);
}
