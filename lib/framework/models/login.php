<?php
namespace Framework\Models;

class Login {
	private function __construct() {

	}
	static function get_user($email, $my_db) {
		$email = filter_var($email, FILTER_SANITIZE_STRING);

		if ($req = $my_db->prepare('
				SELECT
					u.id, u.email, u.pass, u.nom, u.prenom, s.nom AS nomsoc, s.position,
					s.description, s.team, s.pack, s.users, s.nbuser, i.type_user,
					i.adress, i.country, i.postal, i.ville, g.url
				FROM utilisateur u
				LEFT JOIN societe s ON u.id = s.id_client
				LEFT JOIN info_user i On i.id_user = u.id
				LEFT JOIN gallerie_images g ON g.id_user = u.id
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