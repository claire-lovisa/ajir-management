<?php
namespace Model;

use \Entity\Reponse;

class ReponseManagerPDO extends ReponseManager
{

  public function add(Reponse $reponse) {

    $requete = $this->dao->prepare('INSERT INTO Reponse SET idReponse = :idReponse, idQuestion = :idQuestion, estCorrecte = :estCorrecte, nomReponse = :nomReponse');

    $requete->bindValue(':idReponse', $reponse->idReponse());
    $requete->bindValue(':idQuestion', $reponse->idQuestion());
    $requete->bindValue(':estCorrecte', $reponse->estCorrecte());
    $requete->bindValue(':nomReponse', $reponse->nomReponse());

    $requete->execute();
  }

  public function count() {
    return $this->dao->query('SELECT COUNT(*) FROM Reponse')->fetchColumn();
  }

  public function getFreeID() {
    $result = $this->dao->query("SHOW TABLE STATUS WHERE `Name` = 'Reponse'");
    $data = $result->fetch();
    $next_increment = $data['Auto_increment'];
    return $next_increment;
  }

  public function delete($id) {
    $requete = $this->dao->prepare('DELETE FROM Reponse WHERE idReponse = :idReponse');
    $requete->bindValue(':idReponse', $id);
    $requete->execute();
  }

  public function getList($debut = -1, $limite = -1) {
    $sql = 'SELECT * FROM Reponse ORDER BY idReponse DESC';

    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }

    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Reponse');

    $listeReponses = $requete->fetchAll();

    $requete->closeCursor();

    return $listeReponses;
  }

  public function getListReponseDuQuiz($idQuestion) {
    $requete = $this->dao->prepare('SELECT * FROM Reponse WHERE idQuestion = :idQuestion');
    $requete->bindValue(':idQuestion', $idQuestion);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Reponse');

    $listeReponses = $requete->fetchAll();

    $requete->closeCursor();

    return $listeReponses;
  }

  public function getUnique($id) {
    $requete = $this->dao->prepare('SELECT * FROM Reponse WHERE idReponse = :idReponse');
    $requete->bindValue(':idReponse', (int) $id, \PDO::PARAM_INT);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Reponse');

    if ($reponse = $requete->fetch())
    {
      return $reponse;
    }

    return null;
  }

  public function modify(Reponse $reponse) {
    $requete = $this->dao->prepare('UPDATE Reponse SET estCorrecte = :estCorrecte, nomReponse = :nomReponse WHERE idReponse = :idReponse');

    $requete->bindValue(':estCorrecte', $reponse->estCorrecte());
    $requete->bindValue(':nomReponse', $reponse->nomReponse());
    $requete->bindValue(':idReponse', $reponse->idReponse());

    $requete->execute();
  }
}
