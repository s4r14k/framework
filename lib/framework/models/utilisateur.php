<?php
namespace framework\models;

class Utilisateur {
	private function __construct() {

	}

	static function getAllUser($my_db) {

		if ($req = $my_db->query('
				SELECT u.id, u.id_api, u.nom, u.prenom, u.email, u.phone, i.status
				FROM utilisateur u
				LEFT JOIN info_user i ON i.id_user = u.id
				ORDER BY u.id DESC
			')) {
			$result = $req->fetchAll(\PDO::FETCH_ASSOC);
			return $result;
		} else {
			return "ERROR";
		}
	}

	static function getAllClient($my_db) {

		if ($req = $my_db->query('
				SELECT u.id, u.id_api, u.nom, u.prenom, u.email, u.phone, i.status, i.is_client, s.id_price, u.user_registerd, c.nom as nomsoc, c.position, c.pack, g.url
					FROM utilisateur u
				LEFT JOIN info_user i ON i.id_user = u.id
				LEFT JOIN stripe s ON s.id_user = u.id
				LEFT JOIN societe c ON c.id_client = u.id
				LEFT JOIN gallerie_images g ON g.id_user = u.id
				WHERE i.type_user = 0
				ORDER BY u.id DESC
			')) {
			$result = $req->fetchAll(\PDO::FETCH_ASSOC);
			return $result;
		} else {
			return "ERROR";
		}
	}

	static function getClientById($id, $my_db) {

		if ($req = $my_db->prepare('
				SELECT u.id, u.id_api, u.nom, u.prenom, u.email, u.phone, i.status, i.is_client, s.id_price, u.user_registerd, c.nom as nomsoc, c.position, c.pack, c.nbuser, g.url
					FROM utilisateur u
				LEFT JOIN info_user i ON i.id_user = u.id
				LEFT JOIN stripe s ON s.id_user = u.id
				LEFT JOIN societe c ON c.id_client = u.id
				LEFT JOIN gallerie_images g ON g.id_user = u.id
				WHERE i.type_user = 0 AND u.id = :id
				ORDER BY u.id DESC
			')) {
			$req->bindParam('id', $id);
			$req->execute();
			$result = $req->fetch(\PDO::FETCH_ASSOC);
			return $result;
		} else {
			return "ERROR";
		}
	}

	static function getTeamByClient($id_client, $my_db) {

		if ($req = $my_db->prepare('
			SELECT team
				FROM societe
			WHERE id_client = :id_client
			LIMIT 1
		')) {
			$req->bindParam('id_client', $id_client);
			$req->execute();

			$result = $req->fetch(\PDO::FETCH_ASSOC);
			return $result;
		} else {
			return "ERROR";
		}
	}

	static function getAllUserByClient($id_client, $my_db) {

		if ($req = $my_db->prepare('
			SELECT u.id, u.id_api, u.nom, u.prenom, u.email, u.phone, u.user_registerd, i.role, i.team, i.status, g.url
				FROM utilisateur u
			LEFT JOIN gallerie_images g ON g.id_user = u.id
			LEFT JOIN info_user i ON i.id_user = u.id
				WHERE i.id_client = :id_client AND i.type_user = 4000
				ORDER BY u.id DESC
		')) {
			$req->bindParam('id_client', $id_client);
			$req->execute();

			$result = $req->fetchAll(\PDO::FETCH_ASSOC);
			return $result;
		} else {
			return "ERROR";
		}
	}

	static function getUser($id_user, $my_db) {

		$id_user = filter_var($id_user, FILTER_SANITIZE_STRING);

		if ($req = $my_db->prepare('
				SELECT u.id, u.nom, u.prenom, u.email
				FROM utilisateur u
				WHERE u.id = :id_user
				LIMIT 1 
			')) {
			$req->bindParam('id_user', $id_user);
			$req->execute();

			$result = $req->fetch(\PDO::FETCH_ASSOC);
			return $result;
		} else {
			return "ERROR";
		}
	}

	static function getUserDetail($id_user, $my_db) {

		$id_user = filter_var($id_user, FILTER_SANITIZE_STRING);

		if ($req = $my_db->prepare('
				SELECT u.id, u.id_api, u.nom, u.prenom, u.email, u.phone, i.team,
					i.role, i.country, i.status, i.timezone, i.quota, i.langue,
					i.adress, i.postal, i.ville, i.date_naissance, g.url
				FROM utilisateur u
				LEFT JOIN info_user i ON i.id_user = u.id
				LEFT JOIN gallerie_images g ON g.id_user = u.id
				WHERE u.id = :id_user
				LIMIT 1 
			')) {
			$req->bindParam('id_user', $id_user);
			$req->execute();

			$result = $req->fetch(\PDO::FETCH_ASSOC);
			return $result;
		} else {
			return "ERROR";
		}
	}

	static function getLinkProfil ($id_user, $my_db) {
		$id_user = filter_var($id_user, FILTER_VALIDATE_INT);

		if ($req = $my_db->prepare('
				SELECT g.image1
				FROM gallerie_images g
				WHERE g.id_user = :id_user
				LIMIT 1 
			')) {
			$req->bindParam('id_user', $id_user);
			$req->execute();

			$result = $req->fetch(\PDO::FETCH_ASSOC);
			return $result;
		} else {
			return "ERROR";
		}

	}

	static function getCodeConfirmation($id_user, $my_db) {

		$id_user = filter_var($id_user, FILTER_VALIDATE_INT);

		if ($req = $my_db->prepare('
				SELECT caractere
				FROM confirmation
				WHERE id_user = :id_user
				LIMIT 1 
			')) {
			$req->bindParam('id_user', $id_user);
			$req->execute();

			$result = $req->fetch(\PDO::FETCH_ASSOC);
			return $result;
		} else {
			return "ERROR";
		}
	}

	static function getUserCommercial($id_user, $my_db) {
		$my_db->beginTransaction();

		$commercial = array();

		$utilisateur = self::getUser($id_user, $my_db);

		if ($req2= $my_db->prepare('
				SELECT c.phone, c.cin, c.occupation, c.disponnibilite, c.date_formation, img.image1
				FROM commercial c
				LEFT JOIN gallerie_images img
				ON img.id = c.photo
				WHERE c.id_user = :id_user
				LIMIT 1 
			')) {
			$req2->bindParam('id_user', $utilisateur['id']);
			$req2->execute();
			$result2 = $req2->fetch(\PDO::FETCH_ASSOC);

		} else {
			echo "ERROR";
		}
		$my_db->commit();
		
		array_push($utilisateur, $result2);
		return $utilisateur;
		
	}

	static function getUserStartup($id_user, $my_db) {
		$my_db->beginTransaction();

		$commercial = array();

		$utilisateur = self::getUser($id_user, $my_db);

		if ($req2= $my_db->prepare('
				SELECT s.raison_social, s.objet_social, s.adresse, s.phone, img.image1, s.date_creation, k.nif, k.stat, k.rcs
				FROM startup s
				LEFT JOIN gallerie_images img
				ON img.id = s.photo
				LEFT JOIN key_startup k
				ON k.id = s.key_startup
				WHERE s.id_user = :id_user
				LIMIT 1 
			')) {
			$req2->bindParam('id_user', $utilisateur['id']);
			$req2->execute();

			$result2 = $req2->fetch(\PDO::FETCH_ASSOC);
		} else {
			echo "ERROR";
		}

		$my_db->commit();

		array_push($utilisateur, $result2);
		return $utilisateur;
	}
}