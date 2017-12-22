<?php
namespace Entity;

use \OCFram\Entity;

/**
* La classe Utilisateur a pour but de modéliser les utilisateurs de l'application, autrement dit les membres actifs.
*/
class Intervenant extends Personne
{
  /**
  * Les compétences de l'intervenant
  */
  protected $competences = [],
  /**
  * Le département
  */
            $departement,
  /**
  * L'identifiant intervenant de l'intervenant, qui sert essentiellement pour la base de données
  */
            $idIntervenant,
/**
 * La date de fin d'adhésion de l'intervenant
 */
            $dateFinAdhesion;

  const COMPETENCES_INVALIDE = 1;
  const DEPARTEMENT_INVALIDE = 2;
  const IDINTERVENANT_INVALIDE = 3;
  const DATEFINADHESION_INVALIDE = 4;

  /**
  * Le constructeur de Intervenant.
  *
  * @param array $donnees Les données qu'on veut mettre dans notre intervenant.
  */
  public function __construct(array $donnees = [])
  {
    parent::__construct($donnees);
  }

  /**
  * Indique si l'utilisateur est valide (tous ses attributs sont remplis) ou non.
  */
  public function isValid()
  {
    return !(empty($this->departement) || empty($this->dateFinAdhesion));
  }

  /**
  * Fixe les compétences de l'intervenant.
  *
  * @param $competences Les compétences à associer à l'intervenant.
  */
  public function setCompetences($competences)
  {
    if (!is_array($competences) || empty($competences))
    {
      $this->erreurs[] = self::COMPETENCES_INVALIDE;
    }
    $this->competences = $competences;
  }

  /**
  * Fixe le département de l'intervenant.
  *
  * @param $departement Le département à associer à l'intervenant
  */
  public function setDepartement($departement)
  {
    if (!is_string($departement) || empty($departement))
    {
      $this->erreurs[] = self::DEPARTEMENT_INVALIDE;
    }
    $this->departement = $departement;
  }

  /**
  * Fixe l'identifiant d'intervenant de l'intervenant.
  *
  * @param $idIntervenant L'identifiant d'intervenant à associer à l'intervenant
  */
    public function setIdIntervenant($idIntervenant)
  {
    if (empty($idIntervenant))
    {
      $this->erreurs[] = self::IDINTERVENANT_INVALIDE;
    }
    $this->idIntervenant = $idIntervenant;
  }

  /**
  * Fixe la date de fin d'adhésion de l'intervenant.
  *
  * @param $dateFinAdhesion L'identifiant d'utilisateur à associer à l'intervenant
  */
    public function setDateFinAdhesion($dateFinAdhesion)
  {
    if (empty($dateFinAdhesion))
    {
      $this->erreurs[] = self::DATEFINADHESION_INVALIDE;
    }
    $this->dateFinAdhesion = $dateFinAdhesion;
  }

  /**
  * Renvoie les compétences de l'intervenant.
  *
  * @return Les compétences de l'intervenant
  */
  public function competences()
  {
    return $this->competences;
  }

  /**
  * Renvoie le département de l'intervenant.
  *
  * @return Le département de l'intervenant
  */
  public function departement()
  {
    return $this->departement;
  }

  /**
  * Renvoie l'identifiant d'intervenant de l'intervenant.
  *
  * @return L'identifiant d'intervenant de l'intervenant
  */
  public function idIntervenant()
  {
    return $this->idIntervenant;
  }

  /**
  * Renvoie la date de fin d'adhésion de l'intervenant.
  *
  * @return La date de fin d'adhésion de l'intervenant
  */
  public function dateFinAdhesion()
  {
    return $this->dateFinAdhesion;
  }

}
