<?php
namespace Entity;

use \OCFram\Entity;

/**
* La classe Reponse a pour but de modéliser les réponses aux questions des quiz de l'application.
*/
class Reponse extends Entity
{
  /**
  * L'identifiant de la réponse
  */
  protected $idReponse;
  /**
  * L'identifiant de la question
  */
  protected $idQuestion;
  /**
  * Indique si c'est la bonne réponse ou non
  */
  protected $estCorrecte;
  /**
  * Le nom de la question
  */
  protected $nomReponse;

  const IDREPONSE_INVALIDE = 1;
  const IDQUESTION_INVALIDE = 2;
  const ESTCORRECTE_INVALIDE = 2;
  const NOMREPONSE_INVALIDE = 4;

  /**
  * Indique si la personne est valide (tous ses attributs sont remplis) ou non.
  */
  public function isValid()
  {
    return !(empty($this->idReponse) || empty($this->idQuestion) || empty($this->nomReponse));
  }

  public function isNew()
  {
    return empty($this->idReponse());
  }


    /**
    * Fixe l'identifiant de la réponse.
    *
    * @param $idReponse L'identifiant de la réponse
    */
    public function setIdReponse($idReponse)
    {
      if (!is_int($idReponse) || empty($idReponse))
      {
        $this->erreurs[] = self::IDREPONSE_INVALIDE;
      }
      $this->idReponse = $idReponse;
    }

  /**
  * Fixe l'identifiant de la question associée à la réponse.
  *
  * @param $idQuestion L'identifiant à associer à la question associée à la réponse
  */
  public function setIdQuestion($idQuestion)
  {
    if (!is_int($idQuestion) || empty($idQuestion))
    {
      $this->erreurs[] = self::IDQUESTION_INVALIDE;
    }
    $this->idQuestion = $idQuestion;
  }

  /**
  * Fixe si la réponse est la bonne ou non.
  *
  * @param $estCorrecte True si c'est la bonne réponse, false sinon
  */
  public function setEstCorrecte($estCorrecte)
  {
    if (!is_bool($estCorrecte) || empty($estCorrecte))
    {
      $this->erreurs[] = self::ESTCORRECTE_INVALIDE;
    }
    $this->estCorrecte = $estCorrecte;
  }

  /**
  * Fixe le nom de la réponse.
  *
  * @param $nomReponse Le nom à associer à la réponse
  */
  public function setNomReponse($nomReponse)
  {
    if (!is_string($nomReponse) || empty($nomReponse))
    {
      $this->erreurs[] = self::NOMREPONSE_INVALIDE;
    }
    $this->nomReponse = strtolower($nomReponse);
  }

  /**
  * Renvoie l'identifiant de la réponse.
  *
  * @return L'identifiant de la réponse
  */
  public function idReponse()
  {
    return $this->idReponse;
  }

  /**
  * Renvoie l'identifiant de la question.
  *
  * @return L'identifiant de la question
  */
  public function idQuestion()
  {
    return $this->idQuestion;
  }

  /**
  * Renvoie si la réponse est correcte ou non.
  *
  * @return True si la réponse est correcte, false sinon
  */
  public function estCorrecte()
  {
    return $this->estCorrecte;
  }

  /**
  * Renvoie le nom de la réponse.
  *
  * @return Le nom de la réponse
  */
  public function nomReponse()
  {
    return $this->nomReponse;
  }

}
