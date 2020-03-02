<?php

class Autoloader {
  private $_extension = '.php';
  private $_namespace;
  private $_path;
  private $_separateur = '\\';

  public function __construct($namespace = null, $path = null)
  {
    $this->_namespace = $namespace;
    $this->_path = $path;
  }

  public function loadClass($classeACharger)
  {
    //\Framework\GestionApp\Logger::getInstance()->addLog('La classe à charger est :'.$classeACharger.'</br>');
    if (null === $this->_namespace || $this->_namespace.$this->_separateur === substr($classeACharger, 0, strlen($this->_namespace.$this->_separateur))) 
    {
      $fichier = '';
      $namespace = '';
      if (false !== ($PosDernierNs = strripos($classeACharger, $this->_separateur))) 
      {
        $namespace = substr($classeACharger, 0, $PosDernierNs);
        $classeACharger = substr($classeACharger, $PosDernierNs + 1);
        $fichier = str_replace($this->_separateur, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
      }
      $fichier .= str_replace('_', DIRECTORY_SEPARATOR, strtolower($classeACharger)) . $this->_extension;

      require ($this->_path !== null ? $this->_path . DIRECTORY_SEPARATOR : '') . $fichier;
    }
  }

   // Enregistre le loader dans la pile
  public function enregistrer()
  {
    spl_autoload_register(array($this, 'loadClass'));
  }

  // Enlève le loader de la pile
  public function supprimer()
  {
    spl_autoload_unregister(array($this, 'loadClass'));
  }

    public function setSeparateur($sep)
  {
    $this->_separateur = $sep;
  }

  public function getSeparateur()
  {
    return $this->_separateur;
  }

  public function setPath($path)
  {
    $this->_path = $path;
  }

  public function getPath()
  {
    return $this->_path;
  }

  public function setExtension($extension)
  {
    $this->_extension = $extension;
  }

  public function getExtension()
  {
    return $this->_extension;
  }
}