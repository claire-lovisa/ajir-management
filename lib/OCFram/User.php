<?php
namespace OCFram;

session_start();

/**
* La classe User a pour but de représenter les visiteurs du site.
*/
class User
{

  /**
   * Retourne l'attribut dont le nom est passé en paramètre.
   *
   * @param $attr Le nom de l'attribut
   *
   * @return L'attribut si il existe, null sinon
   */
  public function getAttribute($attr)
  {
    return isset($_SESSION[$attr]) ? $_SESSION[$attr] : null;
  }

  /**
   * Donne le message informatif assigné à l'utilisateur.
   *
   * @return $flash Le message informatif
   */
  public function getFlash()
  {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $flash;
  }

  /**
   * Indique si l'utilisateur a un message informatif qui lui est associé.
   *
   * @return bool TRUE si il a un message, FALSE sinon
   */
  public function hasFlash()
  {
    return isset($_SESSION['flash']);
  }

  /**
   * Indique si l'utlisateur est authentifié.
   *
   * @return bool TRUE si il est authentifié, FALSE sinon
   */
  public function isAuthenticated()
  {
    return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
  }

  /**
   * Fixe un nouvel attribut et sa valeur dans les variables de session.
   *
   * @param $attr L'attribut à ajouter
   * @param $value La valeur de l'attribut à ajouter
   */
  public function setAttribute($attr, $value)
  {
    $_SESSION[$attr] = $value;
  }

  /**
   * Rend l'utlisateur authentifié.
   *
   * @param $authenticated Booléen indiquant si l'utilisateur est authentifié ou non
   *
   * @throws InvalidArgumentException Exception lancée si la valeur passée en paramètre n'est pas un booléen
   */
  public function setAuthenticated($authenticated = true)
  {
    if (!is_bool($authenticated))
    {
      throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setAuthenticated() doit être un boolean');
    }

    $_SESSION['auth'] = $authenticated;
  }

  /**
   * Associe un message informatif à l'utilisateur via une variable de session.
   *
   * @param $value Le message informatif
   */
  public function setFlash($value)
  {
    $_SESSION['flash'] = $value;
  }
}
