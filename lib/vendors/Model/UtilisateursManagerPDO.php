<?php
namespace Model;

use \Entity\Utilisateur;
use \Entity\Personne;

class UtilisateursManagerPDO extends UtilisateursManager
{

  public function add(Utilisateur $utilisateur) {

    $idUtilisateur = $this->getFreeID();
    $utilisateur->setIdUtilisateur($idUtilisateur);
    $personne = new Personne([
      'email' => $utilisateur->email(),
      'prenom' => $utilisateur->prenom(),
      'nom' => $utilisateur->nom()
    ]);

    $personneManager = new PersonnesManagerPDO($this->dao);
    $personneManager->save($personne);

    $idPersonne=$personne->id();



    $requete = $this->dao->prepare('INSERT INTO Utilisateur SET mdpHache = :mdpHache, droits = :droits, idUtilisateur = :id, idPersonne = :idPersonne, estValide = :estValide');

    $requete->bindValue(':droits', $utilisateur->droits());
    $requete->bindValue(':mdpHache', $utilisateur->mdpHache());
    $requete->bindValue(':idPersonne', $idPersonne);
    $requete->bindValue(':id', $idUtilisateur);
    $requete->bindValue(':estValide', $utilisateur->estValide());

    $requete->execute();
  }

  public function count() {
    return $this->dao->query('SELECT COUNT(*) FROM Utilisateur')->fetchColumn();
  }

  public function getFreeID() {
    $result = $this->dao->query("SHOW TABLE STATUS WHERE `Name` = 'Utilisateur'");
    $data = $result->fetch();
    $next_increment = $data['Auto_increment'];
    return $next_increment;
  }

  public function delete($id) {
    $requete = $this->dao->prepare('DELETE FROM Utilisateur WHERE idUtilisateur = :id');
    $requete->bindValue(':id', $id);
    $requete->execute();
  }

  public function getList($debut = -1, $limite = -1) {
    $sql = 'SELECT * FROM Utilisateur ORDER BY id DESC';

    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }

    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Utilisateur');

    $listeUtilisateurs = $requete->fetchAll();

    $requete->closeCursor();

    return $listeUtilisateurs;
  }

  public function getListNonValides() {
    $sql = 'SELECT * FROM Utilisateur u
              INNER JOIN Personne p
              ON u.idPersonne = p.idPersonne
              WHERE u.estValide = "0"
              ORDER BY u.idUtilisateur DESC';

    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Utilisateur');

    $listeUtilisateurs = $requete->fetchAll();

    $requete->closeCursor();

    return $listeUtilisateurs;
  }

  public function getUnique($id) {
    $requete = $this->dao->prepare('SELECT * FROM Utilisateur WHERE idUtilisateur = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Utilisateur');

    if ($utilisateur = $requete->fetch())
    {
      return $utilisateur;
    }

    return null;
  }

  public function modify(Utilisateur $utilisateur) {
    $requete = $this->dao->prepare('UPDATE Utilisateur SET mdpHache = :mdpHache, droits = :droits, estValide = :estValide WHERE idUtilisateur = :idUtilisateur');

    $requete->bindValue(':droits', $utilisateur->droits());
    $requete->bindValue(':mdpHache', $utilisateur->mdpHache());
    $requete->bindValue(':estValide', $utilisateur->estValide());
    $requete->bindValue(':idUtilisateur', $utilisateur->idUtilisateur());

    $requete->execute();

  }
}
