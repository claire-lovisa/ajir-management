<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Question;

abstract class QuestionManager extends Manager
{
  /**
   * Méthode permettant d'ajouter une question.
   * @param $question La question à ajouter
   * @return void
   */
  abstract protected function add(Question $question);

  /**
   * Méthode permettant d'enregistrer une question.
   * @param $question La question à enregistrer
   * @return void
   */
  public function save(Question $question)
  {
    if ($question->isValid())
    {
      $question->isNew() ? $this->add($question) : $this->modify($question);
    }
    else
    {
      throw new \RuntimeException('La question doit être validée pour être enregistrée');
    }
  }

  /**
   * Méthode renvoyant le nombre de questions au total.
   * @return int
   */
  abstract public function count();

  /**
   * Méthode permettant de supprimer une question.
   * @param $id L'identifiant de la question à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode retournant une liste de questions demandée.
   * @param $debut La première question à sélectionner
   * @param $limite Le nombre de questions à sélectionner
   * @return array La liste des questions. Chaque entrée est une instance de Question.
   */
  abstract public function getList($debut = -1, $limite = -1);

  /**
   * Méthode retournant une liste de questions appartenant à un quiz précis.
   * @param $idQuiz L'identifiant du quiz dont on veut les questions
   * @return array La liste des questions. Chaque entrée est une instance de Question.
   */
  abstract public function getListQuestionDuQuiz($idQuiz);

  /**
   * Méthode retournant une question précise.
   * @param $id L'identifiant de la question à récupérer
   * @return Question La question demandée
   */
  abstract public function getUnique($id);

  /**
   * Méthode permettant de modifier une question.
   * @param $question La question à modifier
   * @return void
   */
  abstract protected function modify(Question $question);
}
