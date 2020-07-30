<?php
namespace framework\gestion;

class Security {

    static function get_token($id_user, $my_db) {

		$id_user = filter_var($id_user, FILTER_VALIDATE_INT);

		if ($req = $my_db->prepare('
				SELECT *
				FROM token
				WHERE id = :id_user
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

    static function set_token($idUser, $caractere, $refresh, $my_db) {
		
		if ($stmt = $my_db->prepare('
				INSERT INTO token 
				SET id = :id_user, access = :caractere, refresh = :refresh, expire = 3600
				ON DUPLICATE KEY UPDATE access = :caractere, refresh = :refresh, expire = 3600

			')) {
			$stmt->execute(array(
				'id_user' => $idUser,
				'caractere' => $caractere,
				'refresh' => $refresh,
            ));
            
            return true;
        }
        return false;
    }
    
}
