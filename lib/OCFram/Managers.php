<?php
namespace OCFram;

/**
* La classe Managers a pour but de gérer les différents managers.
*/
class Managers
{
  /**
  * L'API utilisée.
  */
  protected $api = null;

  /**
  * Le DAO utilisé.
  */
  protected $dao = null;

  /**
  * La liste des managers sous forme de tableau.
  */
  protected $managers = [];

  /**
   * Le constructeur de Managers.
   *
   * @param $api L'API qu'on veut utiliser
   * @param $dao Le DAO qu'on veut utiliser
   */
  public function __construct($api, $dao)
  {
    $this->api = $api;
    $this->dao = $dao;
  }

  /**
   * Donne le manager du module passé en paramètre. Si ce manager n'est pas dans la liste des managers, il y est ajouté.
   *
   * @param $module Le module dont on veut le manager
   *
   * @throws InvalidArgumentException Exception lancée si le module spécifié est invalide
   *
   * @return $this->managers[$module]
   */
  public function getManagerOf($module)
  {

    if (!is_string($module) || empty($module))
    {
      throw new \InvalidArgumentException('Le module spécifié est invalide');
    }

    if (!isset($this->managers[$module]))
    {

      $manager = '\\Model\\'.$module.'Manager'.$this->api;

      $this->managers[$module] = new $manager($this->dao);

    }

    return $this->managers[$module];
  }
}
