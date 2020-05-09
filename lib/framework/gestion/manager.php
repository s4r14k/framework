<?php
namespace framework\gestion;

class Manager {
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

	static function image ($img1, $img2, $my_db) {
		if ($stmt = $my_db->prepare('
				INSERT INTO gallerie_images (image1, image2, date)
				VALUES (:image1, :image2, NOW())

			')) {
			$stmt->execute(array(
				'image1' => $img1,
				'image2' => $img2 
			));
		}
	}

	static function add_image ($id, $img1, $img2, $my_db) {
		if ($stmt = $my_db->prepare('
				INSERT INTO gallerie_images
				SET id_user = :id, image1 = :image1, image2 = :image2, date = NOW()
				ON DUPLICATE KEY UPDATE image1 = :image1, image2 = :image2, date = NOW()

			')) {
			$stmt->execute(array(
				'id' => $id,
				'image1' => $img1,
				'image2' => $img2 
			));
		}
	}
	
	static function key_startup ($nif, $stat, $rcs, $my_db) {
		if ($stmt = $my_db->prepare('
				INSERT INTO key_startup (nif, stat, rcs)
				VALUES (:nif, :stat, :rcs)

			')) {
			$stmt->execute(array(
				'nif' => $nif,
				'stat' => $stat,
				'rcs' => $rcs 
			));
		}
    }
    
    static function set_utilisateur ($nom, $prenom, $email, $phone, $pass, $role, $my_db) {

		if ($stmt = $my_db->prepare('
				INSERT INTO utilisateur (nom, prenom, email, phone, pass, role, user_registerd)
				VALUES (:nom, :prenom, :email, :phone, :pass, :role, NOW())

			')) {
			$stmt->execute(array(
				'nom' => $nom,
				'prenom' => $prenom,
				'email' => $email,
				'phone' => $phone,
                'pass' => $pass,
				'role' => $role ,
                 
			));
		}
    }

    static function delete_user ($id_user, $my_db) {

    	$id_user = filter_var($id_user, FILTER_VALIDATE_INT);

    	if ($stmt = $my_db->prepare('
				DELETE FROM utilisateur
				WHERE id = :id_utilisateur
			')) {
			$stmt->execute(array(
				'id_utilisateur' => $id_user,
			));

			return true;
		} else {
			return false;
		}
    }

    static function update_info_utilisateur ($id, $adress, $postal, $ville, $date_naissance, $my_db) {

		if ($stmt = $my_db->prepare('
				INSERT INTO info_user
				SET id_user = :id, adress = :adress, postal = :postal, ville = :ville, date_naissance = :date_naissance
				ON DUPLICATE KEY UPDATE adress = :adress, postal = :postal, ville = :ville, date_naissance = :date_naissance

			')) {
			$stmt->execute(array(
				'id' => $id,
				'adress' => $adress,
				'postal' => $postal,
				'ville' => $ville,
				'date_naissance' => $date_naissance,
			));

			$stmt = "";
			$id_user = "";
			$image_id = "";
		}
    }

    static function update_utilisateur ($id, $nom, $prenom, $email, $phone, $adress, $postal, $ville, $date_naissance, $img1, $my_db) {

    	$my_db->beginTransaction();

    	self::add_image($id, $img1, $img1, $my_db);

		self::update_info_utilisateur($id, $adress, $postal, $ville, $date_naissance, $my_db);

		if ($stmt = $my_db->prepare('
				UPDATE utilisateur 
				SET nom = :nom, prenom = :prenom, email = :email, phone = :phone
				WHERE id = :id
			')) {
			$stmt->execute(array(
				'id' => $id,
				'nom' => $nom,
				'prenom' => $prenom,
				'email' => $email,
				'phone' => $phone,
			));

			$my_db->commit();
			$stmt = "";
			$id_user = "";
			$image_id = "";

			return true;
		}
    }
	
	static function update_is_pay ($id, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user 
				SET is_pay = 1
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
				'id' => $id,
			));
		}
    }
	
	static function update_premium ($id, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user 
				SET membre = 1
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
				'id' => $id,
			));
		}
    }

    static function set_stripe_customer ($id_user, $id_stripe, $my_db) {	
		
	$my_db->beginTransaction();

	self::update_is_pay($id_user, $my_db);
	
	$id_user = filter_var($id_user, FILTER_VALIDATE_INT);
	$id_stripe = filter_var($id_stripe, FILTER_SANITIZE_STRING);

		if ($stmt = $my_db->prepare('
				INSERT INTO stripe 
				SET id = :id_utilisateur, id_stripe = :id_stripe, date_ajout = NOW()
				ON DUPLICATE KEY UPDATE id_stripe = :id_stripe, date_ajout = NOW()

			')) {
			$stmt->execute(array(
				'id_utilisateur' => $id_user,
				'id_stripe' => $id_stripe,
			));
			
			$my_db->commit();
		}
    }

    static function update_pass ($email, $pass, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE utilisateur 
				SET pass = :pass
				WHERE email = :email
			')) {
			$stmt->execute(array(
				'email' => $email,
				'pass' => $pass
			));

			return true;
		} else {
			return false;
		}
    }

    static function update_validation_facture ($id, $validation, $my_db) {

    	$id = filter_var($id, FILTER_VALIDATE_INT);

		if ($stmt = $my_db->prepare('
				UPDATE factures 
				SET validation = :validation
				WHERE id = :id
			')) {
			$stmt->execute(array(
				'id' => $id,
				'validation' => $validation
			));
		}
    }

    static function update_etat_facture ($id, $etat, $my_db) {

    	$id = filter_var($id, FILTER_VALIDATE_INT);
    	$etat = filter_var($etat, FILTER_VALIDATE_INT);

		if ($stmt = $my_db->prepare('
				UPDATE factures 
				SET etat = :etat
				WHERE id = :id
			')) {
			$stmt->execute(array(
				'id' => $id,
				'etat' => $etat
			));
			return true;
		}
    }

	static function set_client_admin ($nom, $prenom, $email, $phone, $pass, $role, $img1, $img2, $my_db) {

		$my_db->beginTransaction();

		// self::image($img1, $img2, $my_db);

		// $id_img = $my_db->query('SELECT id As id_image FROM gallerie_images ORDER BY id desc limit 1');
        // $image_id = $id_img->fetch();
        
        self::set_utilisateur($nom, $prenom, $email, $phone, $pass, $role, $my_db);
		
		$user = $my_db->query('SELECT id, nom, prenom, email, role FROM utilisateur ORDER BY id desc limit 1');
		$retour = $user->fetch();
		self::update_info_utilisateur($retour['id'], "", "", "", "00:00:0000", $my_db);


		$my_db->commit();
		$stmt = "";
		$id_user = "";
		$image_id = "";


		return $retour;

	}

	static function confirmEmail ($idUser, $isConfirm, $caractere, $my_db) {
		
		if ($stmt = $my_db->prepare('
				INSERT INTO confirmation 
				SET id_user = :id_user, is_confirm = :is_confirm, caractere = :caractere, date_confirm = NOW()
				ON DUPLICATE KEY UPDATE is_confirm = :is_confirm, caractere = :caractere, date_confirm = NOW()

			')) {
			$stmt->execute(array(
				'id_user' => $idUser,
				'is_confirm' => $isConfirm,
				'caractere' => $caractere,
                 
			));
		}

	}
	 
	static function set_facture ($nom, $link, $titulaire, $validation, $etat, $ref, $my_db) {
		
		if ($stmt = $my_db->prepare('
				INSERT INTO factures (nom, link, titulaire, date_ajout, validation, etat, ref)
				VALUES (:nom, :link, :titulaire, NOW(), :validation, :etat, :ref)

			')) {
			$stmt->execute(array(
				'nom' => $nom,
				'link' => $link,
				'titulaire' => $titulaire,
				'validation' => $validation,
				'etat' => $etat,
				'ref' => $ref
                 
			));
		}

	}
	
	static function set_prix_facture ($id, $prix_constate, $difference_prix, $date_constat, $enseigne, $my_db) {
		
		
		
		if ($stmt = $my_db->prepare('
				UPDATE factures
				SET prix_constate = :prix_constate, difference_prix = :difference_prix, date_constat = :date_constat, enseigne = :enseigne
				WHERE id = :id

			')) {
			$stmt->execute(array(
				'id' => $id,
				'prix_constate' => $prix_constate,
				'difference_prix' => $difference_prix,
				'date_constat' => $date_constat, 
				'enseigne' => $enseigne,
			));
			
			return true;
		} else {
			return false;
		}

	}
	
	static function set_remboursement_facture ($id, $remboursement, $my_db) {
		
		if ($stmt = $my_db->prepare('
				UPDATE factures
				SET remboursement = :remboursement
				WHERE id = :id

			')) {
			$stmt->execute(array(
				'id' => $id,
				'remboursement' => $remboursement,
			));
			
			return true;
		} else {
			return false;
		}

	}

	static function set_startup ($nom, $prenom, $email, $phone, $pass, $role, $raison_social, $objet_social, $adresse, $nif, $stat, $rcs, $img1, $img2, $my_db) {
		$my_db->beginTransaction();

		self::image("startup", "", $img1, $img2, $my_db);

		$id_img = $my_db->query('SELECT id As id_image FROM gallerie_images ORDER BY id desc limit 1');
        $image_id = $id_img->fetch();
        
        self::set_utilisateur($nom, $prenom, $email, $pass, $role, $my_db);

        $id = $my_db->query('SELECT id As id_user FROM utilisateur ORDER BY id desc limit 1');
		$id_user = $id->fetch();

		self::key_startup($nif, $stat, $rcs, $my_db);

		$id_key_startup = $my_db->query('SELECT id As id_key FROM key_startup ORDER BY id desc limit 1');
		$id_key = $id_key_startup->fetch();

		if ($stmt = $my_db->prepare('
				INSERT INTO startup (id_user, raison_social, objet_social, adresse, phone, photo, date_creation, key_startup)
				VALUES (:id_user, :raison_social, :objet_social, :adresse, :phone, :photo, :date_creation, :key_startup)
			')) {
			$stmt->execute(array(
				'id_user' => $id_user['id_user'],
				'raison_social' => $raison_social,
				'objet_social' => $objet_social,
				'adresse' => $adresse,
				'phone' => $phone,
				'photo' => $image_id['id_image'],
				'date_creation' => $date_creation,
				'key_startup' => $id_key['id_key']
			));
		}


		$my_db->commit();
		$stmt = "";
		$id_user = "";
		$image_id = "";

	}
	
	static function set_contact ($email, $sujets, $message, $my_db) {
	    if ($stmt = $my_db->prepare('
				INSERT INTO contact (email, id_sujets, message, date_contact)
				VALUES (:email, :id_sujet, :message, NOW())
			')) {
			$stmt->execute(array(
				'email' => $email,
				'id_sujet' => $sujets,
				'message' => $message
			));
		}
	}
	
	static function update_commercial ($id, $nom, $prenom, $pass, $image, $my_db) {
	    $my_db->beginTransaction();
	    
	    if ($stmt = $my_db->prepare('
				UPDATE utilisateur
                    SET nom = :nom, prenom = :prenom, pass = :pass
                WHERE id = :id
                
			')) {
			$stmt->execute(array(
			    'id' => $id,
				'nom' => $nom,
				'prenom' => $prenom,
				'pass' => $pass
			));
		}
		
		if ($stmt = $my_db->prepare('
				UPDATE gallerie_images
                    SET image1 = :image
                WHERE id = :id
                
			')) {
			$stmt->execute(array(
				'id' => $id,
				'image' => $image
			));
		}
		
		$my_db->commit();
	}
}