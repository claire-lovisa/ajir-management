<?php
namespace OCFram;

/**
* La classe NotNullValidator a pour but de vérifier qu'une valeur n'est pas nulle.
*/
class NotNullValidator extends Validator
{
  public function isValid($value)
  {
    return $value != '';
  }
}
