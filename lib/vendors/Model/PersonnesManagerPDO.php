<?php
namespace Model;

use \Entity\Personne;

class PersonnesManagerPDO extends PersonnesManager
{

  public function add(Personne $personne) {
    $id = $this->getFreeID();
    $personne->setId($id);

    $requete = $this->dao->prepare('INSERT INTO Personne SET nom = :nom, prenom = :prenom, email = :email, idPersonne = :id');

    $requete->bindValue(':nom', $personne->nom());
    $requete->bindValue(':prenom', $personne->prenom());
    $requete->bindValue(':email', $personne->email());
    $requete->bindValue(':id', $id);

    $requete->execute();
  }

  public function count() {
    return $this->dao->query('SELECT COUNT(*) FROM Personne')->fetchColumn();
  }

  public function getFreeID() {
    $result = $this->dao->query("SHOW TABLE STATUS WHERE `Name` = 'Personne'");
    $data = $result->fetch();
    $next_increment = $data['Auto_increment'];
    return $next_increment;
  }

  public function delete($id) {
    $requete = $this->dao->prepare('DELETE FROM Personne WHERE id = :id');
    $requete->bindValue(':nom', $id);
    $requete->execute();
  }

  public function getList($debut = -1, $limite = -1) {
    $sql = 'SELECT * FROM Personne ORDER BY id DESC';

    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }

    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Personne');

    $listePersonnes = $requete->fetchAll();

    $requete->closeCursor();

    return $listePersonnes;
  }

  public function getUnique($id) {
    $requete = $this->dao->prepare('SELECT * FROM Personne WHERE id = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Personne');

    if ($personne = $requete->fetch())
    {
      return $personne;
    }

    return null;
  }

  protected function modify(Personne $personne) {
    $requete = $this->dao->prepare('UPDATE Personne SET id = :id, nom = :nom, prenom = :prenom, email = :email');

    $requete->bindValue(':nom', $personne->nom());
    $requete->bindValue(':prenom', $personne->prenom());
    $requete->bindValue(':email', $personne->email());
    $requete->bindValue(':id', $personne->id(), \PDO::PARAM_INT);

    $requete->execute();
  }
}
