<?php
namespace framework\models;

class Taxe {

	static function getTaxeByJuridiction($juridiction, $my_db) {

		if ($req = $my_db->prepare('
				SELECT *
				    FROM taxe
				WHERE juridiction = :juridiction
				    LIMIT 1
			')) {
			$req->bindParam('juridiction', $juridiction);
			$req->execute();

			$result = $req->fetch(\PDO::FETCH_ASSOC);
			return $result;
		} else {
			return "ERROR";
		}
	}
}