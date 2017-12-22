<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Inscription;

class InscriptionManagerPDO extends InscriptionManager
{

  public function countEmail($email) {
    $req = $this->dao->prepare('SELECT COUNT(*) FROM Personne WHERE email = :email');
    $req->execute(array(
      'email' => $email
    ));
    return $req->fetchColumn();
  }

}
