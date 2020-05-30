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

	static function image ($theme, $miniature, $img1, $img2, $my_db) {
		if ($stmt = $my_db->prepare('
				INSERT INTO gallerie_images (type, img_miniature, image1, image2)
				VALUES (:theme, :miniature, :image1, :image2)

			')) {
			$stmt->execute(array(
				'theme' => $theme,
				'miniature' => $miniature,
				'image1' => $img1,
				'image2' => $img2 
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

		$date_creation = date("Y/m/d");
		if ($stmt = $my_db->prepare('
				INSERT INTO products (id_product, label, price_month, price_year, description, created, groupe)
				VALUES (:id_product, :label, :price_month, :price_year, :description, :created, :groupe)
			')) {
			$stmt->execute(array(
				'id_product' => $id_product, 
				'label' => $label, 
				'price_month' => $price_month, 
				'price_year' => $price_year, 
				'description' => $description,	
				'created' => $date_creation,
				'groupe' => $groupe
                 
			));
		}

		$my_db->commit();
		$stmt = "";
		$id_prix = "";
		$image_id = "";
    }

	
}