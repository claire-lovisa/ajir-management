<?php
namespace Model;

use \Entity\Utilisateur;
use \Entity\Respo;

class ResposManagerPDO extends ResposManager
{

  public function add(Respo $respo) {

    $idRespo = $this->getFreeID();
    echo 'idRespo : '.$idRespo.' fin. ';
    $respo->setIdRespo($idRespo);

    $utilisateur = new Utilisateur([
      'email' => $respo->email(),
      'prenom' => $respo->prenom(),
      'nom' => $respo->nom(),
      'mdpHache' => $respo->mdpHache(),
      'estValide'=> $respo->estValide()
    ]);
    $utilisateur->setDroits($respo->droits());

    $utilisateurManager = new UtilisateursManagerPDO($this->dao);
    $utilisateurManager->save($utilisateur);

    $idUtilisateur=$utilisateur->idUtilisateur();

    $requete = $this->dao->prepare('INSERT INTO Respo SET rang = :rang, anneeMandat = :anneeMandat, idRespo = :idRespo, idUtilisateur = :idUtilisateur');

    $requete->bindValue(':rang', $respo->rang());
    $requete->bindValue(':anneeMandat', $respo->anneeMandat());
    $requete->bindValue(':idUtilisateur', $idUtilisateur);
    $requete->bindValue(':idRespo', $idRespo);

    $requete->execute();
  }

  public function count() {
    return $this->dao->query('SELECT COUNT(*) FROM Respo')->fetchColumn();
  }

  public function getFreeID() {
    $result = $this->dao->query("SHOW TABLE STATUS WHERE `Name` = 'Respo'");
    $data = $result->fetch();
    $next_increment = $data['Auto_increment'];
    return $next_increment;
  }

  public function delete($id) {
    $requete = $this->dao->prepare('DELETE FROM Respo WHERE id = :id');
    $requete->bindValue(':id', $id);
    $requete->execute();
  }

  public function getList($debut = -1, $limite = -1) {
    $sql = 'SELECT * FROM Respo r
              INNER JOIN Utilisateur u
              ON r.idUtilisateur = u.idUtilisateur
              INNER JOIN Personne p
              ON u.idPersonne = p.idPersonne
              ORDER BY r.idRespo DESC';

    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }

    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Respo');

    $listeUtilisateurs = $requete->fetchAll();

    $requete->closeCursor();

    return $listeUtilisateurs;
  }

  public function getUnique($id) {
    $requete = $this->dao->prepare('SELECT * FROM Respo WHERE idRespo = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Respo');

    if ($utilisateur = $requete->fetch())
    {
      return $utilisateur;
    }

    return null;
  }

  public function modify(Respo $respo) {
    $requete = $this->dao->prepare('UPDATE Respo SET rang = :rang, anneeMandat = :anneeMandat');

    $requete->bindValue(':rang', $respo->rang());
    $requete->bindValue(':anneeMandat', $respo->anneeMandat());

    $requete->execute();

    $utilisateur = new Utilisateur([
      'email' => $respo->email(),
      'prenom' => $respo->prenom(),
      'nom' => $respo->nom(),
      'mdpHache' => $respo->mdpHache(),
      'estValide' => $respo->estValide()
    ]);
    $utilisateur->setDroits($respo->droits());

    $utilisateurManager = new UtilisateursManagerPDO($this->dao);
    $utilisateurManager->save($utilisateur);
  }
}
