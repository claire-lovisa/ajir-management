<?php
namespace Entity;

use \OCFram\Entity;

/**
* La classe Quiz a pour but de modéliser les quiz de l'application.
*/
class Quiz extends Entity
{
  /**
  * L'identifiant du quiz
  */
  protected $idQuiz;
  /**
  * Le nom du quiz
  */
  protected $nomQuiz;

  const IDQUIZ_INVALIDE = 1;
  const NOMQUIZ_INVALIDE = 2;

  /**
  * Indique si la personne est valide (tous ses attributs sont remplis) ou non.
  */
  public function isValid()
  {
    return !(empty($this->idQuiz) || empty($this->nomQuiz));
  }

  public function isNew()
  {
    return empty($this->idQuiz());
  }

  /**
  * Fixe l'identifiant du quiz.
  *
  * @param $idQuiz Le 'identifiant à associer au quiz
  */
  public function setIdQuiz($idQuiz)
  {
    if (!is_int($idQuiz) || empty($idQuiz))
    {
      $this->erreurs[] = self::IDQUIZ_INVALIDE;
    }
    $this->idQuiz = $idQuiz;
  }

  /**
  * Fixe le nom du quiz.
  *
  * @param $nomQuiz Le nom à associer au quiz
  */
  public function setNomQuiz($nomQuiz)
  {
    if (!is_string($nomQuiz) || empty($nomQuiz))
    {
      $this->erreurs[] = self::NOMQUIZ_INVALIDE;
    }
    $this->nomQuiz = strtolower($nomQuiz);
  }

  /**
  * Renvoie l'identifiant du quiz.
  *
  * @return L'identifiant du quiz
  */
  public function idQuiz()
  {
    return $this->idQuiz;
  }

  /**
  * Renvoie le nom du quiz.
  *
  * @return Le nom du quiz
  */
  public function nomQuiz()
  {
    return $this->nomQuiz;
  }

}
