<?php
namespace OCFram;

/**
 * La classe ApplicationComponent permet de représenter les composants d'une application.
 */
abstract class ApplicationComponent
{

  /**
  * L'application à laquelle appartiennent les composants.
  */
  protected $app;

  /**
   * Constructeur du composant de l'application.
  */
  public function __construct(Application $app)
  {
    $this->app = $app;
  }

  /**
   * Renvoie l'application à laquelle appartient le composant.
   *
   * @return Application $this->app L'application
  */
  public function app()
  {
    return $this->app;
  }
}
