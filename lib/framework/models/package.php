<?php
namespace Framework\Models;

class Package {
	use Hydrator;

	private $package = [];
	private $description = [];
	private $gamme = [];
	private $image = [];
	private $hotel = [];
	private $restauration = [];
	private $guidage = [];

	public function __construct(array $donnees = []) {
    	if (!empty($donnees)) {
      		$this->hydrate($donnees);
    	}
  	}

	static function getPackage ($de, $a, $my_db) {

  		$_de = filter_var($de, FILTER_VALIDATE_INT);
		$_a = filter_var($a, FILTER_VALIDATE_INT);

  		if ($stmt = $my_db->prepare('
  				SELECT p.id, p.nom, img.img_miniature, img.image1, img.image2, d.courte, d.longue, h.nom_h, h.location, h.prix_h, r.nom_r, r.prix_r, frais.description, frais.prix_g
  				FROM package p
  				INNER JOIN gallerie_images img
  				ON p.image_id = img.id
  				INNER JOIN description d
  				ON p.description_id = d.id
  				INNER JOIN hotel h
  				ON p.hotel_id = h.id
  				INNER JOIN restauration r
  				ON p.restaurant_id = r.id
  				INNER JOIN guidage frais
  				ON p.guidage_id = frais.id
  				ORDER BY p.id DESC
  				LIMIT :_de, :_a

  			')) {

  			 $stmt->bindParam('_de', $_de, \PDO::PARAM_INT);
		  	 $stmt->bindParam('_a', $_a, \PDO::PARAM_INT);
			 $stmt->execute();
        		
        		$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			echo "ERROR";
		}

		$stmt->closeCursor();


		return $result;
	}
	static function getPackageById ($id, $my_db) {

  		$id = filter_var($id, FILTER_VALIDATE_INT);

  		if ($stmt = $my_db->prepare('
  				SELECT p.id, p.nom, img.img_miniature, img.image1, img.image2, d.courte, d.longue, h.nom_h, h.location, h.prix_h, r.nom_r, r.prix_r, frais.description, frais.prix_g
  				FROM package p
  				INNER JOIN gallerie_images img
  				ON p.image_id = img.id
  				INNER JOIN description d
  				ON p.description_id = d.id
  				INNER JOIN hotel h
  				ON p.hotel_id = h.id
  				INNER JOIN restauration r
  				ON p.restaurant_id = r.id
  				INNER JOIN guidage frais
  				ON p.guidage_id = frais.id
  				WHERE p.id = :id
  				LIMIT 1

  			')) {

  			 $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
			 $stmt->execute();
        		
        		$result = $stmt->fetch(\PDO::FETCH_ASSOC);
		} else {
			echo "ERROR";
		}

		$stmt->closeCursor();


		return $result;
	}
	static function getHotel ($de, $a, $my_db) {

    	$_de = filter_var($de, FILTER_VALIDATE_INT);
    	$_a = filter_var($a, FILTER_VALIDATE_INT);

	    if ($stmt = $my_db->prepare('
	       SELECT h.id, h.nom_h, h.location, h.prix_h, d.courte, d.longue, img.image1
	       FROM hotel h
	       INNER JOIN description d
		   ON h.description_id = d.id
		   INNER JOIN gallerie_images img
		   ON h.image_id = img.id
	       ORDER BY h.id DESC
	       LIMIT :_de, :_a
	      ')) {
	      	$stmt->bindParam('_de', $_de, \PDO::PARAM_INT);
	  		$stmt->bindParam('_a', $_a, \PDO::PARAM_INT);
	  		$stmt->execute();

	      $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
	    } else {
	      echo "ERROR";
	    }
    	$stmt->closeCursor();

    	return $result;
	}
	static function getHotelById ($id, $my_db) {
		$id = filter_var($id, FILTER_VALIDATE_INT);
    	
	    if ($stmt = $my_db->prepare('
	       SELECT h.id, h.nom_h, h.location, h.prix_h, d.courte, d.longue, img.image1
	       FROM hotel h
	       INNER JOIN gallerie_images img
		   ON h.image_id = img.id
	       INNER JOIN description d
		   ON h.description_id = d.id
		   WHERE h.id = :id
	       LIMIT 1
	      ')) {
	      	$stmt->bindParam('id', $id, \PDO::PARAM_INT);
	  		$stmt->execute();

	      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
	    } else {
	      echo "ERROR";
	    }
    	$stmt->closeCursor();

    	return $result;

	}

	static function get_restauration ($id, $my_db) {

		$id = filter_var($id, FILTER_VALIDATE_INT);

	    if ($stmt = $my_db->prepare('
	       SELECT id, nom_r, prix_h
	       FROM restauration
	       WHERE id = :id 
	      ')) {
	      $stmt->bindParam('id', $id, \PDO::PARAM_INT);

	      $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
	    } else {
	      echo "ERROR";
	    }
    	$stmt->closeCursor();

    	return $result;

	}
}

