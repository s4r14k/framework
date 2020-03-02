<?php
/*
*
*---------------------------------------------------------
*				Alpha Group Madagascar 
*				(c) 2018 Madagascar
*---------------------------------------------------------
*
*@author 	S4r14k
*@email 	sarikraf@gmail.com
*/

//soit a changer le path par www.alphaGroup.com?
define("BASE", $_SERVER['DOCUMENT_ROOT'].'/alphaGroup');

//Définir que cette page est un page contenant du JSON
header("Content-Type: application/json;charset=UTF-8");
header("Accept-Language: en-US");
header("Access-Control-Allow-origin: http://localhost:8080");
header("Access-Control-Allow-credentials: true");
header("cache-control: no-cache, no-store");


//pour la base donnée et la fonction autoload pour charger tous les class
require BASE.'/lib/Framework/Databases/database.php';
require_once BASE.'/lib/Framework/Gestion/Autoloader.php';

$FrameworkLoader = new Autoloader('Framework', BASE.'/lib');
$FrameworkLoader->enregistrer();

$modelLoader = new Autoloader('Vendor', BASE.'/lib');
$modelLoader->enregistrer();

/*----------------------------------------------------------------------------------------
----- Gestion la fonction getJSON pour afficher dans la vue web --------------------------
-----------------------------------------------------------------------------------------*/

function getJSON ($de, $a, $my_db, $location) {
	switch ($location) {
		case 'Apropos':
			$re = \Framework\Models\Apropos::getApropos($de, $a, $my_db);
			\Vendor\Models\ResponseJSON::ecrireFichier($re, BASE."/Web/API/JSON/{$location}.json");
			break;

		case 'package':
			$re = \Framework\Models\Package::getPackage($de, $a, $my_db);
			\Vendor\Models\ResponseJSON::ecrireFichier($re, BASE."/Web/API/JSON/{$location}.json");
			break;

		case 'hotel':
			$re = \Framework\Models\Package::getHotel($de, $a, $my_db);
			\Vendor\Models\ResponseJSON::ecrireFichier($re, BASE."/Web/API/JSON/{$location}.json");
			break;

		case 'location_voiture':
			$re = \Framework\Models\location::get_location_voiture($de, $a, $my_db);
			\Vendor\Models\ResponseJSON::ecrireFichier($re, BASE."/Web/API/JSON/{$location}.json");
			break;
		
		default:
			
			break;
	}
	
}

function aleatoire ($my_db) {
	$values_max = \Vendor\Controls\Setter::get_number_max($my_db);

	$a = mt_rand(0, $values_max);
	
	if ($values_max - $a < 5) {
		return $a - 5;
	} else {
		return $a;
	}
}

function news ($my_db) {
	$value = \Vendor\Controls\Setter::get_number_max($my_db);
	return $value;	
}

//La liste des fichier json à écrire
$liste = array("Apropos", "package", "hotel", "location_voiture");

//Générer une valeur aléatoire
$valeur = aleatoire($my_db);

if (isset($_GET['req'])) {
	foreach ($liste as $listes) {
		getJSON (0, 5, $my_db, $listes);
		echo true;
	}
} elseif (isset($_GET['type']) && $_GET['type'] == 'hotel') {
	$re = \Framework\Models\Package::getHotel(0, 11, $my_db);
	$result = \Vendor\Models\ResponseJSON::encodeFichier($re);
	echo $result;
} elseif (isset($_GET['id'], $_GET['option']) && $_GET['option'] == 'hotel') {
	$id = \Framework\Gestion\Verification::check_type($_GET['id']);
	$re = \Framework\Models\Package::getHotelById($id, $my_db);
	$result = \Vendor\Models\ResponseJSON::encodeFichier($re);
	echo $result;
} elseif (isset($_GET['id'], $_GET['option']) && $_GET['option'] == 'package') {
	$id = \Framework\Gestion\Verification::check_type($_GET['id']);
	$re = \Framework\Models\Package::getPackageById($id, $my_db);
	$result = \Vendor\Models\ResponseJSON::encodeFichier($re);
	echo $result;
} elseif (isset($_GET['type']) && $_GET['type'] == 'package') {
	$re = \Framework\Models\Package::getPackage(0, 11, $my_db);
	$result = \Vendor\Models\ResponseJSON::encodeFichier($re);
	echo $result;
} elseif (isset($_GET['type']) && $_GET['type'] == 'location_voiture') {
	$re = \Framework\Models\Location::get_location_voiture(0, 11, $my_db);
	$result = \Vendor\Models\ResponseJSON::encodeFichier($re);
	echo $result;
} elseif (isset($_GET['id'], $_GET['option']) && $_GET['option'] == 'location_voiture') {
	$id = \Framework\Gestion\Verification::check_type($_GET['id']);
	$re = \Framework\Models\Location::getLocationVoitureById($id, $my_db);
	$result = \Vendor\Models\ResponseJSON::encodeFichier($re);
	echo $result;
} else {
	$moi = array("ERROR");
	$result = \Vendor\Models\ResponseJSON::encodeFichier($moi);
	echo $result;
}
