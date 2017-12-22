<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Reponse;

abstract class ReponseManager extends Manager
{
  /**
   * Méthode permettant d'ajouter une réponse.
   * @param $reponse La réponse à ajouter
   * @return void
   */
  abstract protected function add(Reponse $reponse);

  /**
   * Méthode permettant d'enregistrer une réponse.
   * @param $reponse La réponse à enregistrer
   * @return void
   */
  public function save(Reponse $reponse)
  {
    if ($reponse->isValid())
    {
      $reponse->isNew() ? $this->add($reponse) : $this->modify($reponse);
    }
    else
    {
      throw new \RuntimeException('La réponse doit être validée pour être enregistrée');
    }
  }

  /**
   * Méthode renvoyant le nombre de réponses au total.
   * @return int
   */
  abstract public function count();

  /**
   * Méthode permettant de supprimer une réponse.
   * @param $id L'identifiant de la réponse à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode retournant une liste de réponses demandée.
   * @param $debut La première réponse à sélectionner
   * @param $limite Le nombre de réponses à sélectionner
   * @return array La liste des réponses. Chaque entrée est une instance de Reponse.
   */
  abstract public function getList($debut = -1, $limite = -1);

  abstract public function getListReponseDuQuiz($idQuestion);

  /**
   * Méthode retournant une réponse précise.
   * @param $id L'identifiant de la réponse à récupérer
   * @return Reponse La réponse demandée
   */
  abstract public function getUnique($id);

  /**
   * Méthode permettant de modifier une réponse.
   * @param $reponse La réponse à modifier
   * @return void
   */
  abstract protected function modify(Reponse $reponse);
}
