<?php
namespace framework\gestion;

class Product {
	static function get_number_max ($my_db) {
		$id = $my_db->query('SELECT id As n_max FROM package ORDER BY id desc limit 1');
		$values = $id->fetch();

		return (int) $values['n_max'];
	}

	static function description ($courte, $longue, $my_db) {
		if ($stmt = $my_db->prepare('
				INSERT INTO description (courte, longue)
				VALUES (:courte, :longue)
			')) {
			$stmt->execute(array(
				'courte' => $courte,
				'longue' => $longue
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
	
	static function setPrice ($brut, $commission, $net, $my_db) {

		$net = filter_var($net, FILTER_VALIDATE_INT);
		
		if ($stmt = $my_db->prepare('
				INSERT INTO prix (brut, commission, net)
				VALUES (:brut, :commission, :net)

			')) {
			$stmt->execute(array(
				'brut' => $brut,
				'commission' => $commission,
				'net' => $net 
			));
		}
    }
    
    static function set_product ($nom, $id_fournisseur, $quantite, $date_creation, $id_categorie, $etat, $img1, $img2, $brut, $commission, $net, $my_db) {
        $my_db->beginTransaction();
        
        self::image("produit", "", $img1, $img2, $my_db);

		$id_img = $my_db->query('SELECT id As id_image FROM gallerie_images ORDER BY id desc limit 1');
        $image_id = $id_img->fetch();

        self::setPrice($brut, $commission, $net, $my_db);
        $id_prix = $my_db->query('SELECT id As id_prix FROM prix ORDER BY id desc limit 1');
        $prix_id = $id_prix->fetch();

        
		$date_creation = date("Y/m/d");
		if ($stmt = $my_db->prepare('
				INSERT INTO produit (nom, id_fournisseur, quantite, date_creation, photo, id_categorie, id_prix, etat)
				VALUES (:nom, :id_fournisseur, :quantite, :date_creation, :photo, :id_categorie, :id_prix, :etat)

			')) {
			$stmt->execute(array(
				'nom' => $nom,
				'id_fournisseur' => $id_fournisseur,
				'quantite' => $quantite,
                'date_creation' => $date_creation,
                'photo' => $image_id['id_image'],
                'id_categorie' => $id_categorie,
                'id_prix' => $prix_id['id_prix'],
                'etat' => $etat
                 
			));
		}

		$my_db->commit();
		$stmt = "";
		$id_prix = "";
		$image_id = "";
    }

	
}