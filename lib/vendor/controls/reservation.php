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
require_once BASE.'/lib/Vendor/controls/client.pdf.php';

$FrameworkLoader = new Autoloader('Framework', BASE.'/lib');
$FrameworkLoader->enregistrer();


function AboutClient($firstName, $lastName, $username, $email, $dateDepart, $address, $address2, $message, $country, $state) {
	$text = "";
	$client = [
		"First Name" => $firstName,
		"Last Name" => $lastName,
		"Username" => $username,
		"Email" => $email,
		"address" => $address,
		"address2" => $address2,
		"Move in Date" => $dateDepart,
		"Country" => $country,
		"State" => $state,
		"Message" => $message

	];
	foreach ($client as $key => $value) {
		$text.= "<p><strong>" . $key . "</strong> : " . $value . "</p>";
	}
	return $text;
}

//Pour le résérvation du Client
function aboutPackage ($nomDuPackage, $hotel, $location, $restaurant) {
	return "<p><strong>Name of Package : </strong> {$nomDuPackage} </p><p><strong>Hotel name and location :</strong> {$hotel} '{$location}'</p><p><strong>Restaurant: </strong> {$restaurant}</p>";
}

function aboutHotel($nom, $location) {
	return "<p><strong>Name of Hotel : </strong> {$nom} </p><p><strong>Localisation :</strong> {$location}</p>";
}
function aboutLocation($nom) {
	return "<p><strong>Voiture : </strong> {$nom} </p>";
}

//Pour le paiement
function paymentPackage ($type, $prix_h, $prix_r, $prix_g, $nombre) {
	$prix = $prix_h + $prix_g + $prix_r;
	$vip = ($prix * $nombre) + ($prix * 20 / 100);
	$raisonnable = ($prix * $nombre) - ($prix * 20 / 100);
	if ($type == 'raisonnable') {
		return '<p>Client choose pack Raisonnable</p><table border="1"><tr><td><label align="center">DESIGNATION</label></td><td><label align="center">PRIX</label></td></tr><tr><td>Hotel</td><td align="center">$'.$prix_h.'</td></tr><tr><td>Restauration</td><td align="center">$'.$prix_r.'</td></tr><tr><td>Guidage</td><td align="center">$'.$prix_g.'</td></tr><tr><td>Nombre de Personne</td><td align="center">'.$nombre.'</td></tr><tr><td><strong>Total - 20%</strong></td><td align="center"><strong>$'. $raisonnable .'</strong></td></tr></table>';
	} elseif ($type == 'normal') {
		return '<p>Client choose pack Normal</p><table border="1"><tr><td><label align="center">DESIGNATION</label></td><td><label align="center">PRIX</label></td></tr><tr><td>Hotel</td><td align="center">$'.$prix_h.'</td></tr><tr><td>Restauration</td><td align="center">$'.$prix_r.'</td></tr><tr><td>Guidage</td><td align="center">$'.$prix_g.'</td></tr><tr><td>Nombre de Personne</td><td align="center">'.$nombre.'</td></tr><tr><td><strong>Total</strong></td><td align="center"><strong>$'. $prix * $nombre .'</strong></td></tr></table>';
	} elseif ($type == 'VIP') {
		return '<p>Client choose pack V.I.P</p><table border="1"><tr><td><label align="center">DESIGNATION</label></td><td><label align="center">PRIX</label></td></tr><tr><td>Hotel</td><td align="center">$'.$prix_h.'</td></tr><tr><td>Restauration</td><td align="center">$'.$prix_r.'</td></tr><tr><td>Guidage</td><td align="center">$'.$prix_g.'</td></tr><tr><td>Nombre de Personne</td><td align="center">'.$nombre.'</td></tr><tr><td>Total + 20%</td><td align="center">$'. $vip .'</td></tr></table>';
	} else {

	}
}
function payementHotel($prix_h, $nombre) {
	return '<table border="1"><tr><td><label align="center">DESIGNATION</label></td><td><label align="center">PRIX</label></td></tr><tr><td>Hotel</td><td align="center">$'.$prix_h.'</td></tr><tr><td>Nombre de Personne</td><td align="center">'.$nombre.'</td></tr><tr><td><strong>Total</strong></td><td align="center"><strong>$'. $prix_h * $nombre .'</strong></td></tr></table>';
}
function payementLocation ($prix) {
	return '<table border="1"><tr><td><label align="center">DESIGNATION</label></td><td><label align="center">PRIX</label></td></tr><tr><td>Location</td><td align="center">$'.$prix.'</td></tr></table>';
}

$firstName = isset($_GET['firstName']) ? \Framework\Gestion\Verification::check_type($_GET['firstName']) : false;
$lastname = isset($_GET['lastName']) ? \Framework\Gestion\Verification::check_type($_GET['lastName']) : false;
$username = isset($_GET['username']) ? \Framework\Gestion\Verification::check_type($_GET['username']) : false;
$email = isset($_GET['email']) ? \Framework\Gestion\Verification::check_type($_GET['email']) : false;
$dateDepart = isset($_GET['dateDepart']) ? \Framework\Gestion\Verification::check_type($_GET['dateDepart']) : false;
$address = isset($_GET['address']) ? \Framework\Gestion\Verification::check_type($_GET['address']) : false;
$address2 = isset($_GET['address2']) ? \Framework\Gestion\Verification::check_type($_GET['address2']) : false;
$message = isset($_GET['message']) ? \Framework\Gestion\Verification::check_type($_GET['message']) : false;
$country = isset($_GET['country']) ? \Framework\Gestion\Verification::check_type($_GET['country']) : false;
$state = isset($_GET['state']) ? \Framework\Gestion\Verification::check_type($_GET['state']) : false;
$payment = isset($_GET['payment']) ? \Framework\Gestion\Verification::check_type($_GET['payment']) : false;
$nombrePerson = isset($_GET['nombrePerson']) ? \Framework\Gestion\Verification::check_type($_GET['nombrePerson']) : false;
$name = $firstName.'_'.$lastname;

$option = isset($_GET['option']) ? $_GET['option'] : "";
$id = isset($_GET['id']) ? \Framework\Gestion\Verification::check_type($_GET['id']) : 0;

switch ($option) {
	case 'package':
		$choix = \Framework\Models\Package::getPackageById($id, $my_db);
		$reserver = aboutPackage($choix['nom'], $choix['nom_h'], $choix['location'], $choix['nom_r']);
		$pay = paymentPackage($payment, $choix['prix_h'], $choix['prix_r'], $choix['prix_g'], $nombrePerson);
		$text = AboutClient($firstName, $lastname, $username, $email, $dateDepart, $address, $address2, $message, $country, $state);
		writeNewClient($name, $text, 'PACKAGE', $reserver, $pay);
		$client = new \Framework\Formulaire\Reservation($name, $email, "", "", "", $message);
		$check = $client->envoyeEmailEtFichier('sarikraf@gmail.com', $name);

		try {
			if ($check) {
				echo $check;
			} else echo false;
		} catch (Exception $e) {
			echo "ERROR:" . $e->messageError();
		}
		
		break;

	case 'hotel':
		$choix = \Framework\Models\Package::getHotelById($id, $my_db);
		$reserver = aboutHotel($choix['nom_h'], $choix['location']);
		$pay = payementHotel($choix['prix_h'], $nombrePerson);
		$text = AboutClient($firstName, $lastname, $username, $email, $dateDepart, $address, $address2, $message, $country, $state);
		writeNewClient($name, $text, 'HOTEL', $reserver, $pay);
		$client = new \Framework\Formulaire\Reservation($name, $email, "", "", "", $message);
		$check = $client->envoyeEmailEtFichier('sarikraf@gmail.com', $name);
		try {
			if ($check) {
				echo $check;
			} else echo false;
		} catch (Exception $e) {
			echo "ERROR:" . $e->messageError();
		}
		
		break;

	case 'location_voiture':
		$choix = \Framework\Models\Location::getLocationVoitureById($id, $my_db);
		$reserver = aboutLocation($choix['nom']);
		$pay = payementLocation($choix['prix']);
		$text = AboutClient($firstName, $lastname, $username, $email, $dateDepart, $address, $address2, $message, $country, $state);
		writeNewClient($name, $text, 'LOCATION VOITURE', $reserver, $pay);
		$client = new \Framework\Formulaire\Reservation($firstName, $email, "", "", "", $message);
		$check = $client->envoyeEmailEtFichier('sarikraf@gmail.com', $name);
		try {
			if ($check) {
				echo $check;
			} else echo false;
		} catch (Exception $e) {
			echo "ERROR:" . $e->messageError();
		}
		
		break;

	case 'contact':
		$client = new \Framework\Formulaire\Reservation($firstName, $email, "", "", "", $message);
		$check = $client->envoyeSimpleEmail();
		try {
			if ($check) {
				echo $check;
			} else echo false;
		} catch (Exception $e) {
			echo "ERROR:" . $e->messageError();
		}

		break;
	
	default:
		# code...
		break;
}

