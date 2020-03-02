<?php
namespace Framework\Gestion;

class reponsehttp {
  protected $page;

  public function ajouterHeader($header) {
    header($header);
  }

  public function rediriger($location) {
    header('Location: '.$location);
    exit;
  }

  public static function rediriger404() {
    require_once $_SERVER['DOCUMENT_ROOT'].'/404.html';
  }

  public static function getPage($page) {
    $page_saint = filter_var($page, FILTER_SANITIZE_STRING);
    $filename = $_SERVER['DOCUMENT_ROOT'].'/bo/vues/'.$page_saint.'.php';
    if(file_exists($filename)) {
      require_once $filename;
    } else {
      self::rediriger404();
    }
  }

  public static function getPageByType($page, $id_type) {
    
    $type = array(
      "1" => "admin",
      "2" => "commercial",
      "3" => "startup"
    );

    $page_saint = filter_var($page, FILTER_SANITIZE_STRING);
    $filename = $_SERVER['DOCUMENT_ROOT'].'/bo/vues/'.$type[$id_type].'/'.$page_saint.'.php';
    if(file_exists($filename)) {
      require_once $filename;
    } else {
      self::rediriger404();
    }
  }
  
  public function setCookie($name, $value = '', $expire = 0, $path = null, $domain = null, $secure = false, $httpOnly = true) {
    setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
  }

  /**
   * Gestion de clé api sécurisé
    */
  public function secureKey($key) {
    
  }
}