<?php
namespace framework\gestion;

class Product {
	static function get_number_max ($my_db) {
		$id = $my_db->query('SELECT count(id) As n_max FROM products');
		$values = $id->fetch();

		return (int) $values['n_max'];
	}

	static function set_id_product ($id, $id_product, $my_db) {
		if ($stmt = $my_db->prepare('
			UPDATE products 
				SET id_product = :id_product
				WHERE id = :id
			')) {
			$stmt->execute(array(
				'id_product' => $id_product,
				'id' => $id
			));
		}
	}

	static function set_description ($id, $courte, $my_db) {
		if ($stmt = $my_db->prepare('
			UPDATE products 
				SET description = :courte
				WHERE id = :id
			')) {
			$stmt->execute(array(
				'courte' => $courte,
				'id' => $id
			));
		}
	}
	
	static function setPrice ($id, $month, $year, $my_db) {

		$net = filter_var($net, FILTER_VALIDATE_INT);
		
		if ($stmt = $my_db->prepare('
			UPDATE products 
				SET price_month = :month, price_year = :year
				WHERE id = :id
			')) {
			$stmt->execute(array(
				'id' => $id,
				'month' => $month,
				'year' => $year 
			));
		}
	}
    
    static function set_product ($id_product, $label, $price_month, $price_year, $description, $groupe, $my_db) {
		if ($stmt = $my_db->prepare('
				INSERT INTO products 
					set id_product = :id_product, 
						label = :label, 
						price_month = :price_month, 
						price_year = :price_year,
						description = :description,
						created = NOW(),
						groupe = :groupe
					ON DUPLICATE KEY UPDATE
						label = :label, 
						price_month = :price_month, 
						price_year = :price_year,
						description = :description,
						created = NOW(),
						groupe = :groupe
			')) {
			$stmt->execute(array(
				'id_product' => $id_product, 
				'label' => $label, 
				'price_month' => $price_month, 
				'price_year' => $price_year, 
				'description' => $description,
				'groupe' => $groupe
                 
			));
		}

		$my_db->commit();
		$stmt = "";
		$id_prix = "";
		$image_id = "";
	}	
}