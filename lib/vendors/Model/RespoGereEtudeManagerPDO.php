<?php
namespace Model;

use \Entity\Respo;
use \Entity\RespoGereEtude;

class RespoGereEtudeManagerPDO extends RespoGereEtudeManager
{

  public function add(RespoGereEtude $respoGereEtude) {

    $respo = new Respo([
      'email' => $respoGereEtude->email(),
      'prenom' => $respoGereEtude->prenom(),
      'nom' => $respoGereEtude->nom(),
      'mdpHache' => $respoGereEtude->mdpHache(),
      'rang' => $respoGereEtude->rang(),
      'anneeMandat' => $respoGereEtude->anneeMandat(),
      'estValide' => $respoGereEtude->estValide()
    ]);
    $respo->setDroits($respoGereEtude->droits());

    $respoManager = new ResposManagerPDO($this->dao);
    $respoManager->add($respo);

  }

  public function count() {
    return $this->dao->query('SELECT COUNT(*) FROM Respo WHERE droit=3')->fetchColumn();
  }


  public function delete($id) {
    $respoManager = new ResposManager($this->dao);
    $respoManager->delete($id);
  }

  public function modify(RespoGereEtude $respoGereEtude) {

    $respo = new Respo([
      'email' => $respoGereEtude->email(),
      'prenom' => $respoGereEtude->prenom(),
      'nom' => $respoGereEtude->nom(),
      'mdpHache' => $respoGereEtude->mdpHache(),
      'rang' => $respoGereEtude->rang(),
      'anneeMandat' => $respoGereEtude->anneeMandat(),
      'estValide' => $respoGereEtude->estValide()
    ]);
    $respo->setDroits($respoGereEtude->droits());

    $respoManager = new ResposManagerPDO($this->dao);
    $respoManager->modify($respo);

  }
}
