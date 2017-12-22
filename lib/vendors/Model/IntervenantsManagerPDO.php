<?php
namespace Model;

use \Entity\Intervenant;
use \Entity\Personne;

class IntervenantsManagerPDO extends IntervenantsManager
{

  public function add(Intervenant $intervenant) {

    $idIntervenant = $this->getFreeID();
    $intervenant->setIdIntervenant($idIntervenant);
    $personne = new Personne([
      'email' => $intervenant->email(),
      'prenom' => $intervenant->prenom(),
      'nom' => $intervenant->nom()
    ]);

    $personneManager = new PersonnesManagerPDO($this->dao);
    $personneManager->save($personne);

    $idPersonne=$personne->id();

    $requete = $this->dao->prepare('INSERT INTO Intervenant SET departement = :departement, dateFinAdhesion = :dateFinAdhesion, idIntervenant = :id, idPersonne = :idPersonne, competences = :competences');

    $requete->bindValue(':departement', $intervenant->departement());
    $requete->bindValue(':dateFinAdhesion', $intervenant->dateFinAdhesion());
    $requete->bindValue(':idPersonne', $idPersonne);
    $requete->bindValue(':id', $idIntervenant);
    $requete->bindValue(':competences', serialize($intervenant->competences()));

    $requete->execute();
  }

  public function count() {
    return $this->dao->query('SELECT COUNT(*) FROM Intervenant')->fetchColumn();
  }

  public function getFreeID() {
    $result = $this->dao->query("SHOW TABLE STATUS WHERE `Name` = 'Intervenant'");
    $data = $result->fetch();
    $next_increment = $data['Auto_increment'];
    return $next_increment;
  }

  public function delete($id) {
    $requete = $this->dao->prepare('DELETE FROM Intervenant WHERE idIntervenant = :id');
    $requete->bindValue(':id', $id);
    $requete->execute();
  }

  public function deleteFromEmail($email) {

    $requete = $this->dao->prepare('DELETE i.* FROM Intervenant i INNER JOIN Personne p ON i.idPersonne = p.idPersonne WHERE email = :email');
    $requete->bindValue(':email', $email);
    $requete->execute();
  }

  public function getList($debut = -1, $limite = -1) {
    $sql = 'SELECT * FROM Intervenant i
              INNER JOIN Personne p
              ON i.idPersonne = p.idPersonne
              ORDER BY i.idIntervenant DESC';

    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }

    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Intervenant');

    $listeIntervenants = $requete->fetchAll();

    foreach ($listeIntervenants as $intervenant){
      $intervenant->setCompetences(unserialize($intervenant->competences()));
    }

    $requete->closeCursor();

    return $listeIntervenants;
  }

  public function getUnique($id) {
    $requete = $this->dao->prepare('SELECT * FROM Intervenant WHERE idIntervenant = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Intervenant');

    if ($intervenant = $requete->fetch())
    {
      $intervenant->setCompetences(unserialize($intervenant->competences()));
      return $intervenant;
    }

    return null;
  }

  protected function modify(Intervenant $intervenant) {
    $requete = $this->dao->prepare('UPDATE Intervenant SET departement = :departement, dateFinAdhesion = :dateFinAdhesion, competences = :competences');

    $requete->bindValue(':departement', $intervenant->departement());
    $requete->bindValue(':dateFinAdhesion', $intervenant->dateFinAdhesion());
    $requete->bindValue(':competences', serialize($intervenant->competences()));

    $requete->execute();

    $personne = new Personne([
      'email' => $utilisateur->email(),
      'prenom' => $utilisateur->prenom(),
      'nom' => $utilisateur->nom()
    ]);
    $personneManager = new PersonnesManagerPDO($this->dao);
    $personneManager->save($personne);
  }
}
