<?php
namespace Entity;

use \OCFram\Entity;

/**
* La classe Respo a pour but de modéliser les responsables de pôle de l'application.
*/
class Respo extends Utilisateur
{
  /**
  * Le rang de la personne
  */
  protected $rang,
  /**
  * L'année du mandat de la personne
  */
            $anneeMandat,
  /**
  * L'identifiant de responsable du responsable, qui sert essentiellement pour la base de données
  */
            $idRespo;

  const RANG_INVALIDE = 1;
  const ANNEEMANDAT_INVALIDE = 2;
  const IDRESPO_INVALIDE = 3;

  /**
  * Le constructeur de Respo. Ses droits sont fixés à 2.
  *
  * @param array $donnees Les données qu'on veut mettre dans notre responsable.
  */
  public function __construct(array $donnees = [])
  {
    parent::__construct($donnees);
    $this->setDroits(2);
  }

  /**
  * Indique si le responsable est valide (tous ses attributs sont remplis) ou non.
  */
  public function isValid()
  {
    return !(empty($this->rang) || empty($this->anneeMandat));
  }

  /**
  * Fixe le rang du responsable.
  *
  * @param $rang Le rang à associer au responsable
  */
  public function setRang($rang)
  {
    if (!is_string($rang) || empty($rang))
    {
      $this->erreurs[] = self::RANG_INVALIDE;
    }
    $this->rang = $rang;
  }

  /**
  * Fixe l'année de mandat du responsable.
  *
  * @param $anneeMandat L'année de mandat à associer au responsable
  */
  public function setAnneeMandat($anneeMandat)
  {
    if (empty($anneeMandat))
    {
      $this->erreurs[] = self::ANNEEMANDAT_INVALIDE;
    }
    $this->anneeMandat = (int) $anneeMandat;
  }

  /**
  * Fixe l'identifiant de responsable du responsable.
  *
  * @param $idRespo L'identifiant de responsable à associer au responsable
  */
  public function setIdRespo($idRespo)
  {
    if (empty($idRespo))
    {
      $this->erreurs[] = self::IDRESPO_INVALIDE;
    }
    $this->idRespo = (int) $idRespo;
  }

  /**
  * Renvoie le rang du responsable.
  *
  * @return Le rang du responsable
  */
  public function rang()
  {
    return $this->rang;
  }

  /**
  * Renvoie l'année de mandat du responsable.
  *
  * @return L'année de mandat du responsable
  */
  public function anneeMandat()
  {
    return $this->anneeMandat;
  }

  /**
  * Renvoie l'identifiant de responsable du responsable.
  *
  * @return L'identifiant de responsable du responsable
  */
  public function idRespo()
  {
    return $this->idRespo;
  }

}
