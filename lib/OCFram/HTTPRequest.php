<?php

namespace OCFram;

/**
 * La classe HTTPRequest permet de représenter les requêtes HTTP du client.
 */
class HTTPRequest extends ApplicationComponent
{

  /**
   * Récupère un cookie.
   *
   * @param $key La clef du cookie
   *
   * @return $_COOKIE[$key] La variable du cookie qui correspond à la clef donnée
   */
  public function cookieData($key)
  {
    return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
  }

  /**
   * Teste si un cookie existe.
   *
   * @param $key La clef du cookie
   *
   * @return bool L'existance du cookie
   */
  public function cookieExists($key)
  {
    return isset($_COOKIE[$key]);
  }

  /**
   * Récupère des données passées en GET.
   *
   * @param $key La clef de la variable
   *
   * @return $_GET[$key] La variable passée en GET qui correspond à la clef donnée
   */
  public function getData($key)
  {
    return isset($_GET[$key]) ? $_GET[$key] : null;
  }

  /**
   * Teste l'existance d'une variable dont la clef est passée en GET.
   *
   * @param $key La clef de la variable
   *
   * @return bool L'existance de la variable dont la clef est passée en GET
   */
  public function getExists($key)
  {
    return isset($_GET[$key]);
  }

  /**
   * Récupère la méthode de requête utilisée pour accéder à la page.
   *
   * @return $_SERVER['REQUEST_METHOD'] La méthode de requête utilisée pour accéder à la page ('GET', 'HEAD', 'POST', 'PUT')
   */
  public function method()
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  /**
   * Récupère des données passées en POST.
   *
   * @param $key La clef de la variable
   *
   * @return $_POST[$key] La variable passée en POST qui correspond à la clef donnée
   */
  public function postData($key)
  {
    return isset($_POST[$key]) ? $_POST[$key] : null;
  }

  /**
   * Teste l'existance d'une variable dont la clef est passée en POST.
   *
   * @param $key La clef de la variable
   *
   * @return bool L'existance de la variable dont la clef est passée en POST
   */
  public function postExists($key)
  {
    return isset($_POST[$key]);
  }

  /**
   * Récupère l'URI qui a été fourni pour accéder à la page.
   *
   * @return $_SERVER['REQUEST_URI'] L'URI qui a été fournie pour accéder à la page
   */
  public function requestURI()
  {
    return $_SERVER['REQUEST_URI'];
  }
}
