<?php
namespace OCFram;

/**
* La classe Validator a pour but de représenter les différentes manières de valider des attributs.
*/
abstract class Validator
{

  /**
  * Le message d'erreur si ce n'est pas validé.
  */
  protected $errorMessage;

  /**
   * Constructeur du validateur.
   *
   * @param $errorMessage Le message d'erreur si la validation échoue
  */
  public function __construct($errorMessage)
  {
    $this->setErrorMessage($errorMessage);
  }

  /**
   * Indique si la valeur est valide ou non.
   *
   * @param $value La valeur à tester
   */
  abstract public function isValid($value);

  /**
   * Fixe un message d'erreur au validateur.
   *
   * @param $errorMessage Le message d'erreur
   */
  public function setErrorMessage($errorMessage)
  {
    if (is_string($errorMessage))
    {
      $this->errorMessage = $errorMessage;
    }
  }

  /**
   * Retourne le message d'erreur assigné au validateur.
   *
   * @return $this->errorMessage Le message d'erreur
   */
  public function errorMessage()
  {
    return $this->errorMessage;
  }
}
