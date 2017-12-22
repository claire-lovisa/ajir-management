<?php
namespace OCFram;

/**
* La classe Application permet de représenter l'application qui est lancée.
*/
abstract class Application
{
  /**
  * La requête HTTP du client.
  */
  protected $httpRequest;

  /**
  * La réponse HTTP pour le client.
  */
  protected $httpResponse;

  /**
  * Le nom de l'application.
  */
  protected $name;

  /**
  * L'utilisateur de l'application.
  */
  protected $user;

  /**
  * La page associée à la réponse HTTP.
  */
  protected $config;


  /**
   * Constructeur de l'application.
  */
  public function __construct()
  {
    $this->httpRequest = new HTTPRequest($this);
    $this->httpResponse = new HTTPResponse($this);
    $this->user = new User($this);
    $this->config = new Config($this);

    $this->name = '';
  }

  /**
   * Renvoie le controleur associé à l'application.
   *
   * @return $controllerClass Le controleur associé à la classe
  */
  public function getController()
  {
    $router = new Router;

    $xml = new \DOMDocument;
    $xml->load(__DIR__.'/../../App/'.$this->name.'/Config/routes.xml');

    $routes = $xml->getElementsByTagName('route');

    // On parcourt les routes du fichier XML.
    foreach ($routes as $route)
    {
      $vars = [];

      // On regarde si des variables sont présentes dans l'URL.
      if ($route->hasAttribute('vars'))
      {
        $vars = explode(',', $route->getAttribute('vars'));
      }

      // On ajoute la route au routeur.
      $router->addRoute(new Route($route->getAttribute('url'), $route->getAttribute('module'), $route->getAttribute('action'), $vars));
    }

    try
    {
      // On récupère la route correspondante à l'URL.
      $matchedRoute = $router->getRoute($this->httpRequest->requestURI());
    }
    catch (\RuntimeException $e)
    {
      if ($e->getCode() == Router::NO_ROUTE)
      {
        // Si aucune route ne correspond, c'est que la page demandée n'existe pas.
        $this->httpResponse->redirect404();
      }
    }

    // On ajoute les variables de l'URL au tableau $_GET.
    $_GET = array_merge($_GET, $matchedRoute->vars());

    // On instancie le contrôleur.
    $controllerClass = 'App\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';
    return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());
  }


  abstract public function run();

  /**
   * Renvoie la requête HTTP.
   *
   * @return HTTPRequest $this->httpRequest La requête HTTP
  */
  public function httpRequest()
  {
    return $this->httpRequest;
  }

  /**
   * Renvoie la réponse HTTP.
   *
   * @return HTTPResponse $this->httpResponse La réponse HTTP
  */
  public function httpResponse()
  {
    return $this->httpResponse;
  }

  /**
   * Renvoie le nom de l'application.
   *
   * @return $this->name Le nom de l'application
  */
  public function name()
  {
    return $this->name;
  }

  /**
   * Renvoie la configuration de l'application.
   *
   * @return $this->config La configuration de l'application
  */
  public function config()
  {
    return $this->config;
  }

  /**
   * Renvoie l'utilisateur de l'application.
   *
   * @return $this->user L'utilisateur de l'application
  */
  public function user()
  {
    return $this->user;
  }
}
