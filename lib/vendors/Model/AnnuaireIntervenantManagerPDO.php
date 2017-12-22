<?php
namespace Model;

class AnnuaireIntervenantManagerPDO extends AnnuaireIntervenantManager
{


  public function getCompetences() {
    $requete = $this->dao->prepare('SELECT competencesPossibles FROM AnnuaireIntervenant');
    $requete->execute();
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\AnnuaireIntervenants');
    $annuaireIntervenants = $requete->fetch();

    return unserialize($annuaireIntervenants->competencesPossibles());

  }

  protected function modify($competences) {
    $requete = $this->dao->prepare('UPDATE AnnuaireIntervenant SET competencesPossibles = :competences');
    $requete->bindValue(':competences', serialize($competences));
    $requete->execute();
  }

}
