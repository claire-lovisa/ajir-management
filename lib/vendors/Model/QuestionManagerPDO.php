<?php
namespace Model;

use \Entity\Question;

class QuestionManagerPDO extends QuestionManager
{

  public function add(Question $question) {
    $requete = $this->dao->prepare('INSERT INTO Question SET idQuestion = :idQuestion, idQuiz = :idQuiz, nomQuestion = :nomQuestion');

    $requete->bindValue(':idQuestion', $question->idQuestion());
    $requete->bindValue(':idQuiz', $question->idQuiz());
    $requete->bindValue(':nomQuestion', $question->nomQuestion());

    $requete->execute();
  }

  public function count() {
    return $this->dao->query('SELECT COUNT(*) FROM Question')->fetchColumn();
  }

  public function getFreeID() {
    $result = $this->dao->query("SHOW TABLE STATUS WHERE `Name` = 'Question'");
    $data = $result->fetch();
    $next_increment = $data['Auto_increment'];
    return $next_increment;
  }

  public function delete($id) {
    $requete = $this->dao->prepare('DELETE FROM Question WHERE idQuestion = :idQuestion');
    $requete->bindValue(':idQuestion', $id);
    $requete->execute();
  }

  public function getList($debut = -1, $limite = -1) {
    $sql = 'SELECT * FROM Question ORDER BY idQuestion DESC';

    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }

    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Question');

    $listeQuestions = $requete->fetchAll();

    $requete->closeCursor();

    return $listeQuestions;
  }


  public function getListQuestionDuQuiz($idQuiz) {
    $requete = $this->dao->prepare('SELECT * FROM Question WHERE idQuiz = :idQuiz');
    $requete->bindValue(':idQuiz', $idQuiz);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Question');

    $listeQuestions = $requete->fetchAll();

    $requete->closeCursor();

    return $listeQuestions;
  }

  public function getUnique($id) {
    $requete = $this->dao->prepare('SELECT * FROM Question WHERE idQuestion = :idQuestion');
    $requete->bindValue(':idQuestion', (int) $id, \PDO::PARAM_INT);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Question');

    if ($question = $requete->fetch())
    {
      return $question;
    }

    return null;
  }

  public function modify(Question $question) {
    $requete = $this->dao->prepare('UPDATE Question SET nomQuestion = :nomQuestion WHERE idQuestion = :idQuestion');

    $requete->bindValue(':nomQuestion', $question->nomQuestion());
    $requete->bindValue(':idQuestion', $question->idQuestion());

    $requete->execute();
  }
}
