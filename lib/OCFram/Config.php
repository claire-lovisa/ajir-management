<?php
namespace OCFram;

/**
* La classe Config a pour but d'externaliser la configuration en passant par des fichiers XML.
*/
class Config extends ApplicationComponent
{

  /**
  * Les variables venant du fichier de configuration.
  */
  protected $vars = [];

  /**
   * Donne la valeur d'une variable dont le nom est passé en paramètre.
   *
   * @param $var Le nom de la variable à récupérer
   *
   * @return La variable si elle existe, null sinon
   */
  public function get($var)
  {
    if (!$this->vars)
    {
      $xml = new \DOMDocument;
      $xml->load(__DIR__.'/../../App/'.$this->app->name().'/Config/app.xml');

      $elements = $xml->getElementsByTagName('define');

      foreach ($elements as $element)
      {
        $this->vars[$element->getAttribute('var')] = $element->getAttribute('value');
      }
    }

    if (isset($this->vars[$var]))
    {
      return $this->vars[$var];
    }

    return null;
  }
}
