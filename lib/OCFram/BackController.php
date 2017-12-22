<?php
namespace OCFram;


/**
* La classe BackController permet de modéliser l'architecture des différents contrôleurs.
*/
abstract class BackController extends ApplicationComponent
{

  /**
  * L'action à exécuter.
  */
  protected $action = '';

  /**
  * Le module où trouver l'action.
  */
  protected $module = '';

  /**
  * La page gérée par contrôleur.
  */
  protected $page = null;

  /**
  * La vue associée au contrôleur.
  */
  protected $view = '';

  /**
  * Le manager associé au contrôleur.
  */
  protected $managers = null;

  /**
   * Constructeur du contrôleur.
   *
   * @param Application $app L'application correspondant au contrôleur
   * @param $module Le module où trouver l'action
   * @param $action L'action à exécuter
  */
  public function __construct(Application $app, $module, $action)
  {
    parent::__construct($app);

    $this->managers = new Managers('PDO', PDOFactory::getMysqlConnexion());
    $this->page = new Page($app);

    $this->setModule($module);
    $this->setAction($action);
    $this->setView($action);
  }

  /**
   * Permet d'exécuter l'action associée au contrôleur.
   *
   * @throws RuntimeException Exception lancée si l'action n'est pas définie sur un module
  */
  public function execute()
  {
    $method = 'execute'.ucfirst($this->action);

    if (!is_callable([$this, $method]))
    {
      throw new \RuntimeException('L\'action "'.$this->action.'" n\'est pas définie sur ce module');
    }

    $this->$method($this->app->httpRequest());
  }

  /**
   * Retourne la page associée au contrôleur.
   *
   * @return $this->varsNames Les noms des variables associés à la route
  */
  public function page()
  {
    return $this->page;
  }

  /**
   * Associe un module au contrôleur
   *
   * @param $module Le module à associer au contrôleur.
   *
   * @throws InvalidArgumentException Exception lancée si le module n'est pas une chaîne de caractères valide
  */
  public function setModule($module)
  {
    if (!is_string($module) || empty($module))
    {
      throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
    }

    $this->module = $module;
  }

  /**
   * Associe une action au contrôleur.
   *
   * @param $action L'action à associer au contrôleur
   *
   * @throws InvalidArgumentException Exception lancée si l'action n'est pas une chaîne de caractères valide
  */
  public function setAction($action)
  {
    if (!is_string($action) || empty($action))
    {
      throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
    }

    $this->action = $action;
  }

  /**
   * Associe une vue au contrôleur.
   *
   * @param $vue La vue à associer au contrôleur
   *
   * @throws InvalidArgumentException Exception lancée si la vue n'est pas une chaîne de caractères valide
  */
  public function setView($view)
  {
    if (!is_string($view) || empty($view))
    {
      throw new \InvalidArgumentException('La vue doit être une chaine de caractères valide');
    }

    $this->view = $view;

    $this->page->setContentFile(__DIR__.'/../../App/'.$this->app->name().'/Modules/'.$this->module.'/Views/'.$this->view.'.php');
  }
}
