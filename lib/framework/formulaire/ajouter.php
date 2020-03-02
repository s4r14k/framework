<?php
//soit a changer le path par www.alphaGroup.com?
define("BASE", $_SERVER['DOCUMENT_ROOT'].'/alphaGroup');

//Définir que cette page est un page contenant du JSON
header("Content-Type: application/json;charset=UTF-8");
header("Accept-Language: en-US");
header("Access-Control-Allow-origin: http://localhost:8080");

//pour la base donnée et la fonction autoload pour charger tous les class
require BASE.'/lib/Framework/Databases/database.php';
require_once BASE.'/lib/Framework/Gestion/Autoloader.php';

$OCFramLoader = new Autoloader('Framework', BASE.'/lib');
$OCFramLoader->enregistrer();

$OCFramLoader = new Autoloader('Vendor', BASE.'/lib');
$OCFramLoader->enregistrer();

/*-------------------------------------------------------------
--- Pour verifier et filtrer les différents variables ---------
-------------------------------------------------------------------------------------------------------*/

$img1 = isset($_FILES['fichier1']) ? new \Framework\Formulaire\Image($_FILES['fichier1']) : false;
$img2 = isset($_FILES['fichier2']) ? new \Framework\Formulaire\Image($_FILES['fichier2']) : false;

$titre = isset($_POST['titre']) ? \Framework\Gestion\Verification::check_type($_POST['titre']) : false;
$contenu = isset($_POST['contenu']) ? \Framework\Gestion\Verification::check_type($_POST['contenu']) : false;
$nom = isset($_POST['nom']) ? \Framework\Gestion\Verification::check_type($_POST['nom']) : false;
$nom_hotel = isset($_POST['nom_hotel']) ? \Framework\Gestion\Verification::check_type($_POST['nom_hotel']) : false;
$nom_restaurant = isset($_POST['nom_restaurant']) ? \Framework\Gestion\Verification::check_type($_POST['nom_restaurant']) : false;
$location = isset($_POST['location']) ? \Framework\Gestion\Verification::check_type($_POST['location']) : false;
$location_hotel = isset($_POST['location_hotel']) ? \Framework\Gestion\Verification::check_type($_POST['location_hotel']) : false;
$prix = isset($_POST['prix']) ? (int) \Framework\Gestion\Verification::check_type($_POST['prix']) : false;
$prix_hotel = isset($_POST['prix_hotel']) ? (int) \Framework\Gestion\Verification::check_type($_POST['prix_hotel']) : false;
$prix_restaurant = isset($_POST['prix_restaurant']) ? (int) \Framework\Gestion\Verification::check_type($_POST['prix_restaurant']) : false;
$guidage = isset($_POST['frais_guidage']) ? (int) \Framework\Gestion\Verification::check_type($_POST['frais_guidage']) : false;
//$gamme = isset($_POST['gamme']) ? (int) \Framework\Gestion\Verification::check_type($_POST['gamme']) : false;
$d_courte = isset($_POST['d_courte']) ? \Framework\Gestion\Verification::check_type($_POST['d_courte']) : false;
$d_long = isset($_POST['d_long']) ? \Framework\Gestion\Verification::check_type($_POST['d_long']) : false;
$duree = isset($_POST['duree']) ? (int) \Framework\Gestion\Verification::check_type($_POST['duree']) : false;

//($titre, $contenu, $nom, $location, $prix, $descriptionC, $descriptionL, $duree )

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

switch ($id) {
	case 1:
		$aPropos = new \Vendor\controls\Setter($titre, $contenu);
		$aPropos->a_propos($img1->filename, $img2->filename, $my_db);
		echo true;
		break;

	case 2:
		$h_otel = new \Vendor\controls\Setter("", "", $nom, $location, $prix, $d_courte, $d_long);
		$h_otel->hotel($img1->filename, $my_db);
		echo true;
		break;

	case 3:
		$location_voiture = new \Vendor\controls\Setter("", "", $nom, "", $prix, "", $d_long, $duree);
		$location_voiture->location($img1->filename, $my_db);
		echo true;
		break;

	case 4:
		//$img_min, $image1, $image2, $nom_hotel, $location_hotel, $prix_hotel, $nom_restaurant, $prix_restaurant, $guidage, $gamme, $my_db
		$package = new \Vendor\controls\Setter("", "", $nom, "", "", $d_courte, $d_long);
		$package->package($img1->filename, $img1->filename, $img2->filename, $nom_hotel, $location_hotel, $prix_hotel, $nom_restaurant, $prix_restaurant, $guidage, $my_db);
		echo true;
		break;

	default:
		header('Location: /alphaGroup/Erreur/404.html');
		break;
}