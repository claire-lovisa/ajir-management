<?php
namespace OCFram;

/**
* La classe Page a pour but de combiner la vue et le layout et de générer le résultat.
*/
class Page extends ApplicationComponent
{

  /**
  * La vue associée à la page.
  */
  protected $contentFile;

  /**
  * Les variables associées à la page.
  */
  protected $vars = [];

  /**
  * Ajoute une variable à la liste des variables de la page.
  *
  * @param $var Le nom de la variable
  * @param $value La valeur de la variable
  *
  * @throws InvalidArgumentException Exception lancée si le nom de la variable est invalide
  */
  public function addVar($var, $value)
  {
    if (!is_string($var) || is_numeric($var) || empty($var))
    {
      throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractères non nulle');
    }

    $this->vars[$var] = $value;
  }

  /**
  * Supprime une variable à la liste des variables de la page.
  *
  * @param $var Le nom de la variable
  *
  * @throws InvalidArgumentException Exception lancée si le nom de la variable est invalide
  */
  public function removeVar($var)
  {
    if (!is_string($var) || is_numeric($var) || empty($var))
    {
      throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractères non nulle');
    }

    unset($this->vars[$var]);
  }

  /**
  * Renvoie la page générée.
  *
  * @throws RuntimeException Exception lancée si la vue spécifiée n'existe pas
  *
  * @return La page générée
  */
  public function getGeneratedPage()
  {
    if (!file_exists($this->contentFile))
    {
      throw new \RuntimeException('La vue spécifiée n\'existe pas');
    }

    $user = $this->app->user();

    extract($this->vars);

    ob_start();
      require $this->contentFile;
    $content = ob_get_clean();

    ob_start();
      require __DIR__.'/../../App/'.$this->app->name().'/Templates/layout.php';
    return ob_get_clean();
  }

  /**
  * Fixe la vue associée à la page.
  *
  * @param $contentFile La vue à associer à la page
  *
  * @throws InvalidArgumentException Exception lancée si la vue spécifiée n'est pas valide
  */
  public function setContentFile($contentFile)
  {
    if (!is_string($contentFile) || empty($contentFile))
    {
      throw new \InvalidArgumentException('La vue spécifiée est invalide');
    }

    $this->contentFile = $contentFile;
  }
}
