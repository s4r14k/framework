<?php
namespace Framework\Models;

trait Hydrator
{
  public function hydrate($data)
  {
    foreach ($data as $clé => $valeur)
    {
      $methode = 'set'.ucfirst($clé);
      
      if (is_callable([$this, $methode]))
      {
        $this->$methode($valeur);
      }
    }
  }
}