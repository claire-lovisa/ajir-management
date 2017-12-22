<?php
namespace Model;

use \OCFram\Manager;
use \Entity\SecGen;
use \Entity\Respo;

/**
 * La classe SecGenManager permet de gérer la relation entre les secrétaires généraux et la base de données.
 */
abstract class SecGenManager extends Manager
{

  /**
   * Méthode permettant d'ajouter un secrétaire général.
   * @param $secGen Le secrétaire général à ajouter
   * @return void
   */
  abstract protected function add(SecGen $secGen);

  /**
   * Méthode permettant d'enregistrer un secrétaire général.
   * @param $secGen Le secrétaire général à enregistrer
   * @return void
   */
  public function save(SecGen $secGen)
  {
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
    $respoManager->save($respo);
  }

  /**
   * Méthode permettant de compter les secrétaires généraux présents dans la base de données.
   * @return Le nombre de secrétaires généraux
   */
  abstract public function count();

  /**
   * Méthode permettant de supprimer un secrétaire général.
   * @param $id L'identifiant du secrétaire général à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode permettant de modifier un secrétaire général.
   * @param $secGen Le secrétaire général à modifier
   * @return void
   */
  abstract protected function modify(SecGen $secGen);
}
