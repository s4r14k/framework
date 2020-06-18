<?php
namespace framework\gestion;

class Delete {

    static function delete_from_utilisateur ($id, $my_db) {

		if ($stmt = $my_db->prepare('
				DELETE FROM utilisateur 
				WHERE id = :id
			')) {
			$stmt->execute(array(
                'id' => $id
			));
		}
    }

    static function delete_from_info_user ($id, $my_db) {

		if ($stmt = $my_db->prepare('
				DELETE FROM info_user 
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id
			));
		}
    }
    
    static function delete_users_client_from_info_user ($id, $my_db) {

		if ($stmt = $my_db->prepare('
				DELETE FROM info_user 
				WHERE id_client = :id
			')) {
			$stmt->execute(array(
                'id' => $id
			));
		}
    }
    
    static function delete_from_stripe ($id, $my_db) {

		if ($stmt = $my_db->prepare('
				DELETE FROM stripe 
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id
			));
		}
	}
    
    static function delete_from_societe ($id, $my_db) {

		if ($stmt = $my_db->prepare('
				DELETE FROM societe 
				WHERE id_client = :id
			')) {
			$stmt->execute(array(
                'id' => $id
			));
		}
	}
}