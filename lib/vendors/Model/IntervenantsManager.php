<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Intervenant;

/**
 * La classe IntervenantsManager permet de gérer la relation entre les intervenants et la base de données.
 */
abstract class IntervenantsManager extends Manager
{

  /**
   * Méthode permettant d'ajouter un intervenant.
   * @param $intervenant L'intervenant à ajouter
   * @return void
   */
  abstract protected function add(Intervenant $intervenant);

  /**
   * Méthode permettant d'enregistrer un intervenant.
   * @param $intervenant L'intervenant à enregistrer
   * @return void
   */
  public function save(Intervenant $intervenant)
  {
    if ($intervenant->isValid())
    {
      $intervenant->isNew() ? $this->add($intervenant) : $this->modify($intervenant);
    }
    else
    {
      throw new \RuntimeException('L\'intervenant doit être valide pour être enregistrée');
    }
  }

  /**
   * Méthode permettant de compter les intervenants présents dans la base de données.
   * @return Le nombre d'intervenants
   */
  abstract public function count();

  /**
   * Méthode permettant de trouver le premier identifiant d'intervenant libre de la base de données.
   * @return Le premier identifiant libre
   */
  abstract public function getFreeID();

  /**
   * Méthode permettant de supprimer un intervenant.
   * @param $id L'identifiant de l'intervenant à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode permettant d'obtenir la liste des intervenants.
   * @param $debut L'indice du premier intervenant à prendre
   * @param $limite Le nombre d'intervenants qu'on souhaite avoir dans la liste
   * @return La liste d'intervenants
   */
  abstract public function getList($debut = -1, $limite = -1);

  /**
   * Méthode permettant un intervenant à partir de son identifiant.
   * @param $id L'identifiant de l'intervenant qu'on souhaite récupérer
   * @return L'intervenant qu'on récupère
   */
  abstract public function getUnique($id);

  /**
   * Méthode permettant de modifier un intervenant.
   * @param $intervenant L'intervenant à modifier
   * @return void
   */
  abstract protected function modify(Intervenant $intervenant);

}
