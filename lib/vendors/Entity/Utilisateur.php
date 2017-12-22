<?php
namespace Entity;

use \OCFram\Entity;

/**
* La classe Utilisateur a pour but de modéliser les utilisateurs de l'application, autrement dit les membres actifs.
*/
class Utilisateur extends Personne
{
  /**
  * Le mot de passe haché de l'utilisateur
  */
  protected $mdpHache,
  /**
  * Les droits de l'utilisateur
  */
            $droits,
  /**
  * L'identifiant utilisateur de l'utilisateur, qui sert essentiellement pour la base de données
  */
            $idUtilisateur,
  /**
  * Si l'utilisateur a été validé par l'administrateur ou non
  */
            $estValide;

  const MDP_INVALIDE = 1;
  const DROITS_INVALIDE = 2;
  const IDUTILISATEUR_INVALIDE = 3;
  const ESTVALIDE_INVALIDE = 4;

  /**
  * Le constructeur de Utilisateur. Ses droits sont fixés à 1.
  *
  * @param array $donnees Les données qu'on veut mettre dans notre utilisateur.
  */
  public function __construct(array $donnees = [])
  {
    parent::__construct($donnees);
    $this->setDroits(1);
  }

  /**
  * Indique si l'utilisateur est valide (tous ses attributs sont remplis) ou non.
  */
  public function isValid()
  {
    return !(empty($this->mdpHache) || empty($this->droits));
  }

  /**
  * Fixe le mot de passe haché de l'utilisateur.
  *
  * @param $mdpHache Le mot de passe haché à associer à l'utilisateur
  */
  public function setMdpHache($mdpHache)
  {
    if (!is_string($mdpHache) || empty($mdpHache))
    {
      $this->erreurs[] = self::MDP_INVALIDE;
    }
    $this->mdpHache = $mdpHache;
  }

  /**
  * Fixe les droits de l'utilisateur.
  *
  * @param $droits Les droits à associer à l'utilisateur
  */
  public function setDroits($droits)
  {
    if (!is_string($droits) || empty($droits))
    {
      $this->erreurs[] = self::DROITS_INVALIDE;
    }
    $this->droits = $droits;
  }

  /**
  * Fixe l'identifiant d'utilisateur de l'utilisateur.
  *
  * @param $idUser L'identifiant d'utilisateur à associer à l'utilisateur
  */
    public function setIdUtilisateur($idUtilisateur)
  {
    if (empty($idUtilisateur))
    {
      $this->erreurs[] = self::IDUTILISATEUR_INVALIDE;
    }
    $this->idUtilisateur = $idUtilisateur;
  }

  /**
  * Indique si l'utilisateur a été validé ou non par l'administrateur
  *
  * @param $estValide 0 si l'utilisateur n'a pas été validé, 1 sinon
  */
    public function setEstValide($estValide)
  {
    if (empty($estValide))
    {
      $this->erreurs[] = self::ESTVALIDE_INVALIDE;
    }
    $this->estValide = $estValide;
  }

  /**
  * Renvoie le mot de passe haché de l'utilisateur.
  *
  * @return Le mot de passe haché de l'utilisateur
  */
  public function mdpHache()
  {
    return $this->mdpHache;
  }

  /**
  * Renvoie les droits de l'utilisateur.
  *
  * @return Les droits de l'utilisateur
  */
  public function droits()
  {
    return $this->droits;
  }

  /**
  * Renvoie l'identifiant d'utilisateur de l'utilisateur.
  *
  * @return L'identifiant d'utilisateur de l'utilisateur
  */
  public function idUtilisateur()
  {
    return $this->idUtilisateur;
  }

  /**
  * Renvoie si l'utilisateur a été validé ou non.
  *
  * @return 0 si l'utilisateur n'a pas été validé, 1 sinon
  */
  public function estValide()
  {
    return $this->estValide;
  }

}
