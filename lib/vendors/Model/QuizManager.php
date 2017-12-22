<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Quiz;

abstract class QuizManager extends Manager
{
  /**
   * Méthode permettant d'ajouter un quiz.
   * @param $quiz Le quiz à ajouter
   * @return void
   */
  abstract protected function add(Quiz $quiz);

  /**
   * Méthode permettant d'enregistrer un quiz.
   * @param $quiz Le quiz à enregistrer
   * @return void
   */
  public function save(Quiz $quiz)
  {
    if ($quiz->isValid())
    {
      $quiz->isNew() ? $this->add($quiz) : $this->modify($quiz);
    }
    else
    {
      throw new \RuntimeException('Le quiz doit être validée pour être enregistrée');
    }
  }

  /**
   * Méthode renvoyant le nombre de quiz total.
   * @return int
   */
  abstract public function count();

  /**
   * Méthode renvoyant le nombre de quiz ayant le nom passé en paramètre.
   * @param $nomQuiz le nom du quiz dont on veut connaitre l'existance
   * @return int
   */
  abstract public function countNomQuiz($nomQuiz);

  /**
   * Méthode permettant de supprimer un quiz.
   * @param $id L'identifiant du quiz à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode retournant une liste de quiz demandée.
   * @param $debut Le premier quiz à sélectionner
   * @param $limite Le nombre de quiz à sélectionner
   * @return array La liste des quiz. Chaque entrée est une instance de Quiz.
   */
  abstract public function getList($debut = -1, $limite = -1);

  /**
   * Méthode retournant un quiz précis.
   * @param $id L'identifiant du quiz à récupérer
   * @return Quiz Le quiz demandé
   */
  abstract public function getUnique($id);

  /**
   * Méthode permettant de modifier un quiz.
   * @param $quiz Le quiz à modifier
   * @return void
   */
  abstract protected function modify(Quiz $quiz);
}
