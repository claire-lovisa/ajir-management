<?php
namespace Model;

use \Entity\Quiz;

class QuizManagerPDO extends QuizManager
{

  public function add(Quiz $quiz) {
    $requete = $this->dao->prepare('INSERT INTO Quiz SET idQuiz = :idQuiz, nomQuiz = :nomQuiz');

    $requete->bindValue(':idQuiz', $quiz->idQuiz());
    $requete->bindValue(':nomQuiz', $quiz->nomQuiz());

    $requete->execute();
  }

  public function count() {
    return $this->dao->query('SELECT COUNT(*) FROM Quiz')->fetchColumn();
  }

  public function countNomQuiz($nomQuiz) {
    $requete = $this->dao->prepare('SELECT COUNT(*) FROM Quiz WHERE nomQuiz = :nomQuiz');
    $requete->bindValue(':nomQuiz', $nomQuiz);
    $requete->execute();
    return $requete->fetchColumn();
  }

  public function getFreeID() {
    $result = $this->dao->query("SHOW TABLE STATUS WHERE `Name` = 'Quiz'");
    $data = $result->fetch();
    $next_increment = $data['Auto_increment'];
    return $next_increment;
  }

  public function delete($id) {
    $requete = $this->dao->prepare('DELETE FROM Quiz WHERE idQuiz = :idQuiz');
    $requete->bindValue(':idQuiz', $id);
    $requete->execute();
  }

  public function getList($debut = -1, $limite = -1) {
    $sql = 'SELECT * FROM Quiz ORDER BY idQuiz DESC';

    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }

    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Quiz');

    $listeQuiz = $requete->fetchAll();

    $requete->closeCursor();

    return $listeQuiz;
  }

  public function getUnique($id) {
    $requete = $this->dao->prepare('SELECT * FROM Quiz WHERE idQuiz = :idQuiz');
    $requete->bindValue(':idQuiz', (int) $id, \PDO::PARAM_INT);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Quiz');

    if ($quiz = $requete->fetch())
    {
      return $quiz;
    }

    return null;
  }

  public function modify(Quiz $quiz) {
    $requete = $this->dao->prepare('UPDATE Quiz SET nomQuiz = :nomQuiz WHERE idQuiz = :idQuiz');

    $requete->bindValue(':nomQuiz', $quiz->nomQuiz());
    $requete->bindValue(':idQuiz', $quiz->idQuiz());

    $requete->execute();
  }
}
