<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Admin;
use \Entity\Respo;

/**
 * La classe AdminManager permet de gérer la relation entre les administrateurs et la base de données.
 */
abstract class AdminManager extends Manager
{

  /**
   * Méthode permettant d'ajouter un administrateur.
   * @param $admin L'administrateur à ajouter
   * @return void
   */
  abstract protected function add(Admin $admin);

  /**
   * Méthode permettant d'enregistrer un administrateur.
   * @param $admin L'administrateur à enregistrer
   * @return void
   */
  public function save(Admin $admin)
  {
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
    $respoManager->save($respo);
  }

  /**
   * Méthode permettant de compter les administrateur présents dans la base de données.
   * @return Le nombre d'administrateurs
   */
  abstract public function count();

  /**
   * Méthode permettant de supprimer un administrateur.
   * @param $id L'identifiant de l'administrateur à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode permettant de modifier un administrateur.
   * @param $admin L'administrateur à modifier
   * @return void
   */
  abstract protected function modify(Admin $admin);
}
