<?php
namespace OCFram;

/**
* La classe Manager a pour but de modéliser chaque manager.
*/
abstract class Manager
{

  /**
  * Le DAO utilisé.
  */
  protected $dao;

  /**
   * Le constructeur de Manager.
   *
   * @param $dao Le DAO qu'on veut utiliser
   */
  public function __construct($dao)
  {

    $this->dao = $dao;

  }
}
