<?php
namespace Framework\Models;

class Login {
	private function __construct() {

	}
	static function get_user($email, $my_db) {
		$email = filter_var($email, FILTER_SANITIZE_STRING);

		if ($req = $my_db->prepare('
				SELECT u.id, u.email, u.pass, u.nom, u.prenom
				FROM utilisateur u
				WHERE u.email = :email
				LIMIT 1 
			')) {
			$req->bindParam('email', $email);
			$req->execute();

			$result = $req->fetch(\PDO::FETCH_ASSOC);
		} else {
			echo "ERROR";
		}
		return $result;
	}
}