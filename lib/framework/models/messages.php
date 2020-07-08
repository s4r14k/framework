<?php
namespace framework\models;

class Messages {

	static function getMessageById($id, $my_db) {

		if ($req = $my_db->prepare('
				SELECT m.id, m.id_to, m.id_from, m.body, m.date_send, m.reason
					FROM `messages` m
				WHERE m.id_from = :id OR m.id_to = :id
				ORDER BY m.id ASC
			')) {
			$req->bindParam('id', $id);
			$req->execute();
			
			$result = $req->fetchAll(\PDO::FETCH_ASSOC);
			return $result;
		} else {
			return array(false);
		}
	}
	
}

