<?php

/*-----------------------------------------------------------------------------
--création de la class database static pour les connexions de base de donnée---
----------------------------------------------------------------------------------------------------*/

/////////////////
//@author: sariak
//@Date: 
/////////////////

class Database extends PDO {
	public function __construct ($file = 'config.ini') {
		if (! $etting = parse_ini_file ($file, TRUE)) throw new exception ('Unable to open ' . $file . '.');
		$dsn = $etting['database']['db_sql'] . ':host=' . $etting['database']['host'] . ';dbname=' . $etting['database']['schema'];
         
        //soit à crypter le mot de pass   
        parent::__construct ($dsn, $etting['database']['db_utilisateur'], '7N5OVWsyYRgB'); // "z[GS}9_ZANQu"

    }
}
//Pour gérer les exceptions
try {
   $my_db = new Database();
   $my_db->exec("set names utf8");
   $my_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
} catch (Exception $e) {
	die ('Erreur ' . $e->getMessage());
}

