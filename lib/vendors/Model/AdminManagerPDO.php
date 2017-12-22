<?php
namespace Model;

use \Entity\Respo;
use \Entity\Admin;

class AdminManagerPDO extends AdminManager
{

  public function add(Admin $admin) {

    $respo = new Respo([
      'email' => $admin->email(),
      'prenom' => $admin->prenom(),
      'nom' => $admin->nom(),
      'mdpHache' => $admin->mdpHache(),
      'rang' => $admin->rang(),
      'anneeMandat' => $admin->anneeMandat(),
      'estValide' => $admin->estValide()
    ]);
    $respo->setDroits($admin->droits());

echo 'estValide : '.$admin->estValide();

    $respoManager = new ResposManagerPDO($this->dao);
    $respoManager->add($respo);

  }

  public function count() {
    return $this->dao->query('SELECT COUNT(*) FROM Respo WHERE droit=5')->fetchColumn();
  }


  public function delete($id) {
    $respoManager = new ResposManager($this->dao);
    $respoManager->delete($id);
  }

  protected function modify(Admin $admin) {

    $respo = new Respo([
      'email' => $admin->email(),
      'prenom' => $admin->prenom(),
      'nom' => $admin->nom(),
      'mdpHache' => $admin->mdpHache(),
      'rang' => $admin->rang(),
      'anneeMandat' => $admin->anneeMandat(),
      'estValide' => $admin->estValide()
    ]);
    $respo->setDroits($admin->droits());

    $respoManager = new ResposManagerPDO($this->dao);
    $respoManager->modify($respo);

  }
}
