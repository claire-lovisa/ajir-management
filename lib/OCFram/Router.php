<?php
namespace OCFram;

/**
* La classe Router permet savoir quelle page exécuter.
*/
class Router
{

  /**
  * Le tableau des routes possibles.
  */
  protected $routes = [];

  /**
  * La constante correspondant à "aucune route".
  */
  const NO_ROUTE = 1;

  /**
   * Ajoute une route au routeur.
   *
   * @param Route $route La route à ajouter
  */
  public function addRoute(Route $route)
  {
    if (!in_array($route, $this->routes))
    {
      $this->routes[] = $route;
    }
  }

  /**
   * Renvoie la route correspondant à un URL donné.
   *
   * @param $url L'URL pour lequel on veut la route
   *
   * @return Route $route La route correspondant à l'URL
   *
   * @throws RuntimeException Une exception si la route n'existe pas
  */
  public function getRoute($url)
  {
    foreach ($this->routes as $route)
    {
      // Si la route correspond à l'URL
      if (($varsValues = $route->match($url)) !== false)
      {
        // Si elle a des variables
        if ($route->hasVars())
        {
          $varsNames = $route->varsNames();
          $listVars = [];

          // On crée un nouveau tableau clé/valeur
          // (clé = nom de la variable, valeur = sa valeur)
          foreach ($varsValues as $key => $match)
          {
            // La première valeur contient entièrement la chaine capturée (voir la doc sur preg_match)
            if ($key !== 0)
            {
              $listVars[$varsNames[$key - 1]] = $match;
            }
          }

          // On assigne ce tableau de variables � la route
          $route->setVars($listVars);
        }

        return $route;
      }
    }

    throw new \RuntimeException('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
  }
}
