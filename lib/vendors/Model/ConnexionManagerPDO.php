<?php
namespace Model;

use \OCFram\Manager;
use \Entity\News;

class ConnexionManagerPDO extends ConnexionManager
{
  /**
   * Méthode renvoyant le nombre d'email identiques à celui passé en paramètre.
   *
   * @param $email L'email dont on veut avoir le nombre d'occurences dans la base de données.
   *
   * @return int
   */
  public function countEmail($email) {
    $req = $this->dao->prepare('SELECT COUNT(*) FROM Personne WHERE email = :email');
    $req->execute(array(
      'email' => $email
    ));
    return $req->fetchColumn();
  }

  /**
   * Méthode renvoyant le mot de passe haché correspondant à un email donné.
   *
   * @param $email L'email dont on veut avoir le nombre d'occurences dans la base de données.
   *
   * @return int
   */
  public function getMdpHache($email) {
    $req = $this->dao->prepare('SELECT u.mdpHache FROM Personne p INNER JOIN Utilisateur u ON p.idPersonne = u.idPersonne WHERE p.email = :email');
    $req->execute(array(
        'email' => $email
    ));
    return $req->fetch()['mdpHache'];
  }

  /**
   * Méthode renvoyant le prenom correspondant à un email donné.
   *
   * @param $email L'email dont on veut avoir le prénom correspondant.
   *
   * @return string Le prénom
   */
  public function getPrenom($email) {
    $req = $this->dao->prepare('SELECT prenom FROM Personne WHERE email = :email');
    $req->execute(array(
        'email' => $email
    ));
    return $req->fetch()['prenom'];
  }

  /**
   * Méthode renvoyant les droits correspondants à un email donné.
   *
   * @param $email L'email dont on veut avoir les droits associés.
   *
   * @return int Les droits
   */
  public function getDroits($email) {
    $req = $this->dao->prepare('SELECT u.droits FROM Personne p INNER JOIN Utilisateur u ON p.idPersonne = u.idPersonne WHERE p.email = :email');
    $req->execute(array(
        'email' => $email
    ));
    return $req->fetch()['droits'];
  }

  public function getEstValide($email) {
    $req = $this->dao->prepare('SELECT u.estValide FROM Personne p INNER JOIN Utilisateur u ON p.idPersonne = u.idPersonne WHERE p.email = :email');
    $req->execute(array(
        'email' => $email
    ));
    return $req->fetch()['estValide'];
  }

}
