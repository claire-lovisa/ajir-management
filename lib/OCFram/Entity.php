<?php
namespace OCFram;

/**
* La classe Entity a pour but de modéliser les entités de l'application.
*/
abstract class Entity implements \ArrayAccess
{
  use Hydrator;

  /**
  * Les erreurs possibles liées à l'entité.
  */
  protected $erreurs = [],
  /**
  * L'ID de l'entité (le même que son identifiant dans la base de données).
  */
            $id;

  /**
  * Le constructeur de Entity.
  *
  * @param array $donnees Les données qu'on veut mettre dans notre entité.
  */
  public function __construct(array $donnees = [])
  {
    if (!empty($donnees))
    {
      $this->hydrate($donnees);
    }

  }

  /**
  * Indique si l'entité a déjà un identifiant ou non.
  *
  * @return bool TRUE si l'entité est nouvelle, FALSE sinon
  */
  public function isNew()
  {
    return empty($this->id);
  }

  /**
  * Renvoie les erreurs liées à l'entité.
  *
  * @return $this->erreurs Les erreurs liées à l'entité
  */
  public function erreurs()
  {
    return $this->erreurs;
  }

  /**
  * Renvoie l'identifiant de l'entité.
  *
  * @return $this->id L'identifiant de l'entité
  */
  public function id()
  {
    return $this->id;
  }

  /**
  * Fixe l'identifiant de l'entité.
  *
  * @param $id L'identifiant de l'entité à fixer
  */
  public function setId($id)
  {
    $this->id = (int) $id;
  }


  public function offsetGet($var)
  {
    if (isset($this->$var) && is_callable([$this, $var]))
    {
      return $this->$var();
    }
  }

  public function offsetSet($var, $value)
  {
    $method = 'set'.ucfirst($var);

    if (isset($this->$var) && is_callable([$this, $method]))
    {
      $this->$method($value);
    }
  }

  public function offsetExists($var)
  {
    return isset($this->$var) && is_callable([$this, $var]);
  }

  public function offsetUnset($var)
  {
    throw new \Exception('Impossible de supprimer une quelconque valeur');
  }
}
