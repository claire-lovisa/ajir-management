<?php
namespace OCFram;

/**
* La classe Route permet de représenter une route.
*/
class Route
{
  /**
  * L'action à exécuter.
  */
  protected $action;

  /**
  * Le module où trouver l'action.
  */
  protected $module;

  /**
  * L'URL auquel correspond la route.
  */
  protected $url;

  /**
  * Le tableau des noms des variables passées par l'URL.
  */
  protected $varsNames;

  /**
  * Le tableau des variables passées par l'URL.
  */
  protected $vars = [];

  /**
   * Constructeur de la route.
   *
   * @param $url L'URL correspondant à la route
   * @param $module Le module où trouver l'action
   * @param $action L'action à exécuter
   * @param array $varNames Les noms des variables
  */
  public function __construct($url, $module, $action, array $varsNames)
  {
    $this->setUrl($url);
    $this->setModule($module);
    $this->setAction($action);
    $this->setVarsNames($varsNames);
  }

  /**
   * Permet de savoir si la route a des variables ou non.
   *
   * @return bool TRUE si la route a des variables, FALSE sinon
  */
  public function hasVars()
  {
    return !empty($this->varsNames);
  }

  /**
   * Permet de savoir si l'URL passé en paramètre correspond à l'URL de la route.
   *
   * @param $url L'URL à tester
   *
   * @return $matches si l'URL correspond, FALSE sinon.
  */
  public function match($url)
  {
    if (preg_match('`^'.$this->url.'$`', $url, $matches))
    {
      return $matches;
    }
    else
    {
      return false;
    }
  }

  /**
   * Associe une action à la route, si elle est valide.
   *
   * @param $action L'action à associer à la route
  */
  public function setAction($action)
  {
    if (is_string($action))
    {
      $this->action = $action;
    }
  }

  /**
   * Associe une action à la route, si elle est valide.
   *
   * @param $action L'action à associer à la route
  */
  public function setModule($module)
  {
    if (is_string($module))
    {
      $this->module = $module;
    }
  }

  /**
   * Associe un URL à la route, si il est valide.
   *
   * @param $url L'URL à associer à la route
  */
  public function setUrl($url)
  {
    if (is_string($url))
    {
      $this->url = $url;
    }
  }

  /**
   * Associe des noms de variables à la route.
   *
   * @param array $varsNames Les noms des variables à associer à la route
  */
  public function setVarsNames(array $varsNames)
  {
    $this->varsNames = $varsNames;
  }

  /**
   * Associe des variables à la route.
   *
   * @param array $vars Les variables à associer à la route
  */
  public function setVars(array $vars)
  {
    $this->vars = $vars;
  }

  /**
   * Retourne l'action associée à la route.
   *
   * @return $this->action L'action associée à la route
  */
  public function action()
  {
    return $this->action;
  }

  /**
   * Retourne le module associé à la route.
   *
   * @return $this->module Le module associé à la route
  */
  public function module()
  {
    return $this->module;
  }

  /**
   * Retourne les variables associées à la route.
   *
   * @return $this->vars Les variables associées à la route
  */
  public function vars()
  {
    return $this->vars;
  }

  /**
   * Retourne les noms des variables associés à la route.
   *
   * @return $this->varsNames Les noms des variables associés à la route
  */
  public function varsNames()
  {
    return $this->varsNames;
  }
}
