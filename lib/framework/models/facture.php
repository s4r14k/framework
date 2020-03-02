<?php
namespace framework\models;

class Facture {
	private function __construct() {

	}

	static function getFacture($my_db) {

		// $id_facture = filter_var($id_facture, FILTER_SANITIZE_STRING);

		if ($req = $my_db->query('
				SELECT f.id, f.nom, f.link, u.prenom as titulaire, u.nom, u.phone, u.email, f.date_ajout, f.validation, f.etat, i.membre, f.prix_constate, f.date_constat, f.difference_prix, f.enseigne, f.remboursement, f.ref
				FROM factures f
				LEFT JOIN utilisateur u ON u.id = f.titulaire
				LEFT JOIN info_user i ON i.id_user = f.titulaire
				WHERE u.role = 1
				ORDER BY f.id DESC
				LIMIT 30
			')) {
			// $req->bindParam('id_facture', $id_facture);
			// $req->execute();

			$result = $req->fetchAll(\PDO::FETCH_ASSOC);
			return $result;
		} else {
			return "ERROR";
		}
	}

	static function getFactureById($id_facture, $my_db) {
		// $my_db->beginTransaction();

		// $commercial = array();

		// $utilisateur = self::getUser($id_user, $my_db);
		
		$id_facture = filter_var($id_facture, FILTER_VALIDATE_INT);

		if ($req2= $my_db->prepare('
				SELECT f.id, f.nom, f.link, u.prenom as titulaire, f.date_ajout, f.validation, f.etat, f.difference_prix, f.remboursement, f.ref
				FROM factures f
				LEFT JOIN utilisateur u ON u.id = f.titulaire
				WHERE f.titulaire = :id_facture
				ORDER BY f.id DESC
			')) {
			$req2->bindParam('id_facture', $id_facture);
			$req2->execute();
			$result2 = $req2->fetchAll(\PDO::FETCH_ASSOC);

		} else {
			echo "ERROR";
		}
		// $my_db->commit();
		
		// array_push($utilisateur, $result2);
		return $result2;
		
	}

	static function getFactureByIdUser($id_facture, $my_db) {
		// $my_db->beginTransaction();

		// $commercial = array();

		// $utilisateur = self::getUser($id_user, $my_db);
		
		$id_facture = filter_var($id_facture, FILTER_VALIDATE_INT);

		if ($req2= $my_db->prepare('
				SELECT f.date_constat, f.difference_prix, f.remboursement, f.prix_constate, f.enseigne
				FROM factures f
				WHERE f.id = :id_facture
			')) {
			$req2->bindParam('id_facture', $id_facture);
			$req2->execute();
			$result2 = $req2->fetch(\PDO::FETCH_ASSOC);

		} else {
			echo "ERROR";
		}
		// $my_db->commit();
		
		// array_push($utilisateur, $result2);
		return $result2;
		
	}

	static function getRemboursement($id_user, $my_db) {
		
		$id_user = filter_var($id_user, FILTER_VALIDATE_INT);

		if ($req2= $my_db->prepare('
				SELECT f.id, f.remboursement
				FROM factures f
				WHERE titulaire = :id_user
				ORDER BY f.id DESC
			')) {
			$req2->bindParam('id_user', $id_user);
			$req2->execute();
			$result2 = $req2->fetchAll(\PDO::FETCH_ASSOC);

		} else {
			echo "ERROR";
		}
		
		return $result2;
		
	}

}