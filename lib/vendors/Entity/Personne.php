<?php
namespace Entity;

use \OCFram\Entity;

/**
* La classe Personne a pour but de modéliser les personnes de l'application.
*/
class Personne extends Entity
{
  /**
  * Le prénom de la personne
  */
  protected $prenom,
  /**
  * Le nom de la personne
  */
            $nom,
  /**
  * L'email de la personne
  */
            $email;

  const PRENOM_INVALIDE = 1;
  const NOM_INVALIDE = 2;
  const EMAIL_INVALIDE = 3;

  /**
  * Indique si la personne est valide (tous ses attributs sont remplis) ou non.
  */
  public function isValid()
  {
    return !(empty($this->prenom) || empty($this->nom) || empty($this->email));
  }

  /**
  * Fixe le prénom de la personne.
  *
  * @param $prenom Le prénom à associer à la personne
  */
  public function setPrenom($prenom)
  {
    if (!is_string($prenom) || empty($prenom))
    {
      $this->erreurs[] = self::PRENOM_INVALIDE;
    }
    $this->prenom = strtolower($prenom);
  }

  /**
  * Fixe le nom de la personne.
  *
  * @param $nom Le nom à associer à la personne
  */
  public function setNom($nom)
  {
    if (!is_string($nom) || empty($nom))
    {
      $this->erreurs[] = self::NOM_INVALIDE;
    }
    $this->nom = strtolower($nom);
  }

  /**
  * Fixe l'email de la personne.
  *
  * @param $email Le prénom à associer à la personne
  */
  public function setEmail($email)
  {
    if (!is_string($email) || empty($email))
    {
      $this->erreurs[] = self::EMAIL_INVALIDE;
    }

    $this->email = $email;
  }

  /**
  * Renvoie le prénom de la personne.
  *
  * @return Le prénom de la personne
  */
  public function prenom()
  {
    return $this->prenom;
  }

  /**
  * Renvoie le nom de la personne.
  *
  * @return Le nom de la personne
  */
  public function nom()
  {
    return $this->nom;
  }

  /**
  * Renvoie l'email de la personne.
  *
  * @return L'email de la personne
  */
  public function email()
  {
    return $this->email;
  }

}
