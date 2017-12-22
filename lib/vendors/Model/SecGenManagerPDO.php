<?php
namespace Model;

use \Entity\Respo;
use \Entity\SecGen;

class SecGenManagerPDO extends SecGenManager
{

  public function add(SecGen $secGen) {

    $respo = new Respo([
      'email' => $secGen->email(),
      'prenom' => $secGen->prenom(),
      'nom' => $secGen->nom(),
      'mdpHache' => $secGen->mdpHache(),
      'rang' => $secGen->rang(),
      'anneeMandat' => $secGen->anneeMandat(),
      'estValide' => $secGen->estValide()
    ]);
    $respo->setDroits($secGen->droits());

    $respoManager = new ResposManagerPDO($this->dao);
    $respoManager->add($respo);

  }

  public function count() {
    return $this->dao->query('SELECT COUNT(*) FROM Respo WHERE droit=4')->fetchColumn();
  }


  public function delete($id) {
    $respoManager = new ResposManager($this->dao);
    $respoManager->delete($id);
  }

  public function modify(SecGen $secGen) {

    $respo = new Respo([
      'email' => $secGen->email(),
      'prenom' => $secGen->prenom(),
      'nom' => $secGen->nom(),
      'mdpHache' => $secGen->mdpHache(),
      'rang' => $secGen->rang(),
      'anneeMandat' => $secGen->anneeMandat(),
      'estValide' => $secGen->estValide()
    ]);
    $respo->setDroits($secGen->droits());

    $respoManager = new ResposManagerPDO($this->dao);
    $respoManager->modify($respo);

  }
}
