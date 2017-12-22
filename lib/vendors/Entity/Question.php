<?php
namespace Entity;

use \OCFram\Entity;

/**
* La classe Question a pour but de modéliser les questions des quiz de l'application.
*/
class Question extends Entity
{
  /**
  * L'identifiant de la question
  */
  protected $idQuestion;
  /**
  * L'identifiant du quiz
  */
  protected $idQuiz;
  /**
  * Le nom de la question
  */
  protected $nomQuestion;

  const IDQUESTION_INVALIDE = 1;
  const IDQUIZ_INVALIDE = 2;
  const NOMQUIZ_INVALIDE = 3;

  /**
  * Indique si la personne est valide (tous ses attributs sont remplis) ou non.
  */
  public function isValid()
  {
    return !(empty($this->idQuestion) || empty($this->idQuiz) || empty($this->nomQuestion));
  }

  public function isNew()
  {
    return empty($this->idQuestion());
  }

  /**
  * Fixe l'identifiant de la question.
  *
  * @param $idQuestion L'identifiant à associer à la question
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
  * Fixe l'identifiant du quiz correspondant à la question.
  *
  * @param $idQuiz L'identifiant du quiz à associer à la question
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
  * Fixe le nom de la question.
  *
  * @param $nomQuestion Le nom à associer à la question
  */
  public function setNomQuestion($nomQuestion)
  {
    if (!is_string($nomQuestion) || empty($nomQuestion))
    {
      $this->erreurs[] = self::NOMQUESTION_INVALIDE;
    }
    $this->nomQuestion = strtolower($nomQuestion);
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
  * Renvoie l'identifiant du quiz.
  *
  * @return L'identifiant du quiz
  */
  public function idQuiz()
  {
    return $this->idQuiz;
  }

  /**
  * Renvoie le nom de la question.
  *
  * @return Le nom de la question
  */
  public function nomQuestion()
  {
    return $this->nomQuestion;
  }

}
