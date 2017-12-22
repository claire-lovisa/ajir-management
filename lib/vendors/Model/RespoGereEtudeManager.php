<?php
namespace Model;

use \OCFram\Manager;
use \Entity\RespoGereEtude;
use \Entity\Respo;

/**
 * La classe RespoGereEtudeManager permet de gérer la relation entre les responsables qui gèrent des études et la base de données.
 */
abstract class RespoGereEtudeManager extends Manager
{

  /**
   * Méthode permettant d'ajouter un responsable études.
   * @param $respoGereEtude Le responsable études à ajouter
   * @return void
   */
  abstract protected function add(RespoGereEtude $respoGereEtude);

  /**
   * Méthode permettant d'enregistrer un responsable études.
   * @param $respoGereEtude Le responsable études à enregistrer
   * @return void
   */
  public function save(RespoGereEtude $respoGereEtude)
  {
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
    $respoManager->save($respo);
  }

  /**
   * Méthode permettant de compter les responsables études présents dans la base de données.
   * @return Le nombre de responsables études
   */
  abstract public function count();

  /**
   * Méthode permettant de supprimer un responsable études.
   * @param $id L'identifiant du responsable études à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode permettant de modifier un responsable études.
   * @param $respoGereEtude Le responsable études à modifier
   * @return void
   */
  abstract protected function modify(RespoGereEtude $respoGereEtude);
}
