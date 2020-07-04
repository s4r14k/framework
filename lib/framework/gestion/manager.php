<?php
namespace framework\gestion;

class Manager extends \framework\gestion\update {

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

	static function add_image ($id, $url, $my_db) {
		if ($stmt = $my_db->prepare('
				INSERT INTO gallerie_images
				SET id_user = :id_user, url = :url
				ON DUPLICATE KEY UPDATE url = :url

			')) {
			$stmt->execute(array(
				'id_user' => $id,
				'url' => $url,
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
    
    static function set_utilisateur ($nom, $prenom, $email, $phone, $pass, $my_db) {

		if ($stmt = $my_db->prepare('
				INSERT INTO utilisateur (nom, prenom, email, phone, pass, user_registerd)
				VALUES (:nom, :prenom, :email, :phone, :pass, NOW())

			')) {
			$stmt->execute(array(
				'nom' => $nom,
				'prenom' => $prenom,
				'email' => $email,
				'phone' => $phone,
                'pass' => $pass
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

    static function update_info_utilisateur ($id, $adress, $country, $postal, $ville, $date_naissance, $period, $my_db) {

		if ($stmt = $my_db->prepare('
				INSERT INTO info_user
				SET id_user = :id, adress = :adress, country = :country, postal = :postal, ville = :ville, date_naissance = :date_naissance, period = :period
				ON DUPLICATE KEY UPDATE adress = :adress, country = :country, postal = :postal, ville = :ville, date_naissance = :date_naissance, period = :period

			')) {
			$stmt->execute(array(
				'id' => $id,
				'adress' => $adress,
				'country' => $country,
				'postal' => $postal,
				'ville' => $ville,
				'date_naissance' => $date_naissance,
				'period' => $period
			));

			$stmt = "";
			$id_user = "";
			$image_id = "";
		}
	}

	static function update_info_utilisateur_client ($id, $status, $country, $role, $type_user, $timezone, $id_client, $team, $langue, $quota, $my_db) {

		if(empty($type_user)) {
			$type_user = "0";
		}

		if ($stmt = $my_db->prepare('
				INSERT INTO info_user
				SET id_user = :id, status = :status, country = :country, role = :role, type_user = :type_user, timezone = :timezone, id_client = :id_client, team = :team, langue = :langue, quota = :quota
				ON DUPLICATE KEY UPDATE status = :status, country = :country, role = :role, type_user = :type_user, timezone = :timezone, id_client = :id_client, team = :team, langue = :langue, quota = :quota

			')) {
			$stmt->execute(array(
				'id' => $id,
				'status' => $status,
				'country' => $country,
				'role' => $role,
				'type_user' => $type_user,
				'timezone' => $timezone,
				'id_client' => $id_client,
				'team' => $team,
				'langue' => $langue,
				'quota' => $quota
			));

			$stmt = "";
			$id_user = "";
			$image_id = "";
		}
    }

    static function update_utilisateur ($id, $nom, $prenom, $email, $phone, $adress, $country, $postal, $ville, $date_naissance, $period, $img1, $my_db) {

    	$my_db->beginTransaction();

    	self::add_image($id, $img1, $img1, $my_db);

		self::update_info_utilisateur($id, $adress, $country, $postal, $ville, $date_naissance, $period, $my_db);

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

    static function update_stripe_customer ($id_user, $token, $customer, $subscription, $card, $coupon, $id_product, $id_price, $id_taxe, $my_db) {
		
		$id_user = filter_var($id_user, FILTER_VALIDATE_INT);

		if ($stmt = $my_db->prepare('
				INSERT INTO stripe 
				SET id_user = :id_utilisateur, token = :token, customer = :customer, subscription = :subscription, card = :card, coupon = :coupon, id_product = :id_product, id_price = :id_price, id_taxe = :id_taxe, date_ajout = NOW()
				ON DUPLICATE KEY UPDATE token = :token, customer = :customer,  subscription = :subscription, card = :card, coupon = :coupon, id_product = :id_product, id_price = :id_price, id_taxe = :id_taxe

			')) {
			$stmt->execute(array(
				'id_utilisateur' => $id_user,
				'token' => $token,
				'customer' => $customer,
				'subscription' => $subscription,
				'card' => $card,
				'coupon' => $coupon,
				'id_product' => $id_product,
				'id_price' => $id_price,
				'id_taxe' => $id_taxe
			));
		}
    }

    static function update_pass ($id_user, $email, $pass, $my_db) {

		$id_user = filter_var($id_user, FILTER_VALIDATE_INT);

		if ($stmt = $my_db->prepare('
				UPDATE utilisateur 
				SET pass = :pass
				WHERE email = :email AND id = :id
			')) {
			$stmt->execute(array(
				'id' => $id_user,
				'email' => $email,
				'pass' => $pass
			));

			return array("valid" => true, "body" => "password updated successffully");
		} else {
			return false;
		}
	}
	
	static function update_users_client ($id_client, $nb, $my_db) {

		$id_client = filter_var($id_client, FILTER_VALIDATE_INT);
		$nb = filter_var($nb, FILTER_VALIDATE_INT);

		$nb += 1;

		if ($stmt = $my_db->prepare('
				UPDATE societe 
				SET users = :nb
				WHERE id_client = :id_client
			')) {
			$stmt->execute(array(
				'id_client' => $id_client,
				'nb' => $nb
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
	
	static function set_societe ($id_user, $nom, $pack, $users, $nbuser, $my_db) {

		if ($stmt = $my_db->prepare('
				INSERT INTO societe
				SET id_client = :id_client, nom = :nom, pack = :pack, users = :users, nbuser = :nbuser
				ON DUPLICATE KEY UPDATE nom = :nom, pack = :pack, users = :users, nbuser = :nbuser
			')) {
			$stmt->execute(array(
				'id_client' => $id_user,
				'nom' => $nom,
				'pack' => $pack,
				'users' => $users,
				'nbuser' => $nbuser
			));
		}
	}

	static function set_client_admin ($nom, $prenom, $email, $phone, $pass, $role, $country, $period, $company, $pack, $nbuser, $img1, $img2, $my_db) {

		$my_db->beginTransaction();

		// self::image($img1, $img2, $my_db);

		// $id_img = $my_db->query('SELECT id As id_image FROM gallerie_images ORDER BY id desc limit 1');
        // $image_id = $id_img->fetch();
        
        self::set_utilisateur($nom, $prenom, $email, $phone, $pass, $my_db);
		
		$user = $my_db->query('SELECT id FROM utilisateur ORDER BY id desc limit 1');
		$retour = $user->fetch();

		// ($id, $adress, $country, $postal, $ville, $date_naissance, $period, $my_db)
		self::update_info_utilisateur($retour['id'], "", $country, "", "", "00:00:0000", $period, $my_db);

		// ($id_user, $nom, $pack, $users, $nbuser, $my_db)
		self::set_societe($retour['id'], $company, $pack, 0, $nbuser, $my_db);

		$my_db->commit();

		$stmt = "";
		$id_user = "";
		$image_id = "";


		return $retour['id'];

	}

	static function set_client_user($nom, $prenom, $email, $phone, $pass, $role, $country, $timezone, $status, $team, $id_client, $users, $img1, $langue, $quota, $my_db) {

		$my_db->beginTransaction();

		// self::image($img1, $img2, $my_db);

		// $id_img = $my_db->query('SELECT id As id_image FROM gallerie_images ORDER BY id desc limit 1');
        // $image_id = $id_img->fetch();
        
        self::set_utilisateur($nom, $prenom, $email, $phone, $pass, $my_db);
		
		$user = $my_db->query('SELECT id FROM utilisateur ORDER BY id desc limit 1');
		$retour = $user->fetch();

		// ($id, $status, $country, $role, $type_user, $timezone, $id_client, $my_db)
		self::update_info_utilisateur_client($retour['id'], $status, $country, $role, 4000, $timezone, $id_client, $team, $langue, $quota, $my_db);

		self::update_users_client($id_client, $users, $my_db);

		if($img1) {
			self::add_image($retour['id'], $img1, $my_db);
		}

		$my_db->commit();

		$stmt = "";
		$id_user = "";
		$image_id = "";


		return true;

	}

	static function update_client_user($id, $nom, $prenom, $email, $phone, $pass, $role, $country, $timezone, $status, $team, $id_client, $users, $img1, $langue, $quota, $my_db) {

		$my_db->beginTransaction();
		
		self::update_nom_utilisateur($id, $nom, $my_db);
		self::update_prenom_utilisateur($id, $prenom, $my_db);
		self::update_email_utilisateur($id, $email, $my_db);
		self::update_phone_utilisateur($id, $phone, $my_db);

		// ($id, $status, $country, $role, $type_user, $timezone, $id_client, $my_db)
		self::update_info_utilisateur_client($id, $status, $country, $role, 4000, $timezone, $id_client, $team, $langue, $quota, $my_db);
		if($img1) {
			self::add_image($id, $img1, $my_db);
		}

		$my_db->commit();

		$stmt = "";
		$id_user = "";
		$image_id = "";


		return true;

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

	static function update_role_user($id, $role, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user
                    SET role = :role
                WHERE id = :id
                
			')) {
			$stmt->execute(array(
			    'id' => $id,
				'role' => $role
			));
		}
	}

	static function update_type_user($id, $role, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user
                    SET type_user = :type
                WHERE id = :id
                
			')) {
			$stmt->execute(array(
			    'id' => $id,
				'type' => $type
			));
		}
	}
	
	static function update_team_client($id, $team, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE societe
                    SET team = :team
                WHERE id_client = :id
                
			')) {
			$stmt->execute(array(
			    'id' => $id,
				'team' => $team
			));
			return array("response" =>"success");
		}

		return array("response" => "failed");
	}

	static function update_company ($id, $nom, $prenom, $position, $adress, $city, $country, $postal, $description, $my_db) {

		$my_db->beginTransaction();
		
		self::update_nom_utilisateur($id, $nom, $my_db);
		self::update_prenom_utilisateur($id, $prenom, $my_db);
		self::update_position_societe($id, $position, $my_db);
		self::update_description_societe($id, $description, $my_db);
		self::update_adress_info_user($id, $adress, $my_db);
		self::update_ville_info_user($id, $city, $my_db);
		self::update_country_info_user($id, $country, $my_db);
		self::update_postal_info_user($id, $postal, $my_db);

		$my_db->commit();
		
		return array("response" =>"success");
    }
}