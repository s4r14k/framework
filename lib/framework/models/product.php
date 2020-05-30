<?php
namespace framework\models;

class Product {
	static function get_number_max ($my_db) {
		$id = $my_db->query('SELECT count(id) As n_max FROM products');
		$values = $id->fetch();

		return (int) $values['n_max'];
    }
    
    static function getProducts ($my_db) {

        if ($req = $my_db->query('
				SELECT *
                    FROM products
                    ORDER BY id ASC
			')) {
			$result = $req->fetchAll(\PDO::FETCH_ASSOC);
			return $result;
		} else {
			return "ERROR";
		}
    }

    static function getProductById($id, $my_db) {

		$id = filter_var($id, FILTER_VALIDATE_INT);

		if ($req = $my_db->prepare('
				SELECT *
				    FROM products
				WHERE id = :id
				    LIMIT 1 
			')) {
			$req->bindParam('id', $id);
			$req->execute();

			$result = $req->fetch(\PDO::FETCH_ASSOC);
			return $result;
		} else {
			return "ERROR";
		}
	}
}