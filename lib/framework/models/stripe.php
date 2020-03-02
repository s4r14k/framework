<?php
namespace framework\models;

class Stripe {
	private function __construct() {

	}

	static function getStripeUser($id_user, $my_db) {

		$id_user = filter_var($id_user, FILTER_VALIDATE_INT);

		if ($req = $my_db->prepare('
				SELECT s.id_stripe
				FROM stripe s
				WHERE s.id = :id_user
				LIMIT 1 
			')) {
			$req->bindParam('id_user', $id_user);
			$req->execute();

			$result = $req->fetch(\PDO::FETCH_ASSOC);
			return $result['id_stripe'];
		} else {
			return "ERROR";
		}
	}
	
	static function isPay($id_user, $my_db) {

		$id_user = filter_var($id_user, FILTER_VALIDATE_INT);

		if ($req = $my_db->prepare('
				SELECT s.id_stripe
				FROM stripe s
				WHERE s.id = :id_user
				LIMIT 1 
			')) {
			$req->bindParam('id_user', $id_user);
			$req->execute();

			$result = $req->fetch(\PDO::FETCH_ASSOC);
			
			if(!empty($result['id_stripe'])) {
				return true;
			} else {
				return false;
			}
			
		} else {
			return false;
		}
	}
}