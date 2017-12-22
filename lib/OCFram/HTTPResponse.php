<?php
namespace OCFram;

/**
 * La classe HTTPResponse permet de représenter la réponse HTTP envoyée au client.
 */
class HTTPResponse extends ApplicationComponent
{
  /**
 * La page associée à la réponse HTTP.
 */
  protected $page;

  /**
   * Ajoute un header spécifique.
   *
   * @param $header Le header
   */
  public function addHeader($header)
  {
    header($header);
  }

  /**
   * Redirige l'utilisateur à la localisation demandée.
   *
   * @param $location La localisation demandée
   */
  public function redirect($location)
  {
    header('Location: '.$location);
    exit;
  }

  /**
   * Redirige l'utilisateur vers une erreur 404.
   */
  public function redirect404()
  {
    $this->page = new Page($this->app);
    $this->page->setContentFile(__DIR__.'/../../Errors/404.html');

    $this->addHeader('HTTP/1.0 404 Not Found');

    $this->send();
  }

  /**
   * Envoie la réponse en générant la page.
   */
  public function send()
  {
    exit($this->page->getGeneratedPage());
  }

  /**
   * Assigne une page à la réponse.
   *
   * @param Page $page La page assignée à la réponse
   */
  public function setPage(Page $page)
  {
    $this->page = $page;
  }

  // Changement par rapport à la fonction setcookie() : le dernier argument est par défaut à true
  /**
   * Ajoute un cookie.
   *
   * @param $name Le nom du cookie
   * @param $value : Le contenu du cookie
   * @param $expire : Le temps après lequel le cookie expire
   * @param $path : Le chemin sur lequel le cookie se trouve
   * @param $domain : Le domaine pour lequel le cookie est disponible
   * @param $secure : Indique si le cookie doit uniquement être transmis à travers une connexion HTTPS
   * @param $httponly : Indique si le cookie n'est accessible que par le protocole HTTP
   */
  public function setCookie($name, $value = '', $expire = 0, $path = null, $domain = null, $secure = false, $httpOnly = true)
  {
    setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
  }
}
