<?php
namespace framework\gestion;

class Update {

    static function update_nom_societe ($id, $nom, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE societe 
				SET nom = :nom
				WHERE id_client = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'nom' => $nom
			));
		}
    }
    
    static function update_description_societe ($id, $description, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE societe 
				SET description = :description
				WHERE id_client = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'description' => $description
			));
		}
    }
    
    static function update_team_societe($id, $team, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE societe
                    SET team = :team
                WHERE id_client = :id
                
			')) {
			$stmt->execute(array(
			    'id' => $id,
				'team' => $team
			));
		}
    }
    
    static function update_pack_societe ($id, $pack, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE societe 
				SET pack = :pack
				WHERE id_client = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'pack' => $pack
			));
		}
    }

    static function update_users_societe ($id, $users, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE societe 
				SET users = :users
				WHERE id_client = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'users' => $users
			));
		}
    }

    static function update_nbuser_societe ($id, $nbuser, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE societe 
				SET nbuser = :nbuser
				WHERE id_client = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'nbuser' => $nbuser
			));
		}
	}
	
	static function update_status_info_user ($id, $status, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user 
				SET status = :status
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'status' => $status
			));
		}
	}
	
	static function update_adress_info_user ($id, $adress, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user 
				SET adress = :adress
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'adress' => $adress
			));
		}
	}
	
	static function update_country_info_user ($id, $country, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user 
				SET country = :country
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'country' => $country
			));
		}
	}
	
	static function update_postal_info_user ($id, $postal, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user 
				SET postal = :postal
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'postal' => $postal
			));
		}
	}
	
	static function update_ville_info_user ($id, $ville, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user 
				SET ville = :ville
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'ville' => $ville
			));
		}
	}
	
	static function update_date_naissance_info_user ($id, $date_naissance, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user 
				SET date_naissance = :date_naissance
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'date_naissance' => $date_naissance
			));
		}
	}
	
	static function update_role_info_user ($id, $role, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user 
				SET role = :role
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'role' => $role
			));
		}
	}
	
	static function update_type_user_info_user ($id, $type_user, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user 
				SET type_user = :type_user
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'type_user' => $type_user
			));
		}
	}
	
	static function update_is_client_info_user ($id, $is_client, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user 
				SET is_client = :is_client
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'is_client' => $is_client
			));
		}
	}
	
	static function update_period_info_user ($id, $period, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user 
				SET period = :period
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'period' => $period
			));
		}
	}
	
	static function update_id_client_info_user ($id, $id_client, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user 
				SET id_client = :id_client
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'id_client' => $id_client
			));
		}
	}
	
	static function update_team_info_user ($id, $team, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user 
				SET team = :team
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'team' => $team
			));
		}
	}
	
	static function update_timezone_info_user ($id, $timezone, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user 
				SET timezone = :timezone
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'timezone' => $timezone
			));
		}
	}
	
	static function update_quota_info_user ($id, $quota, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE info_user
				SET quota = :quota
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'quota' => $quota
			));
		}
	}
	
	static function update_token_stripe ($id, $token, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE stripe 
				SET token = :token
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'token' => $token
			));
		}
	}
	
	static function update_customer_stripe ($id, $customer, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE stripe 
				SET customer = :customer
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'customer' => $customer
			));
		}
	}
	
	static function update_subscription_stripe ($id, $subscription, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE stripe 
				SET subscription = :subscription
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'subscription' => $subscription
			));
		}
	}
	
	static function update_card_stripe ($id, $card, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE stripe 
				SET card = :card
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'card' => $card
			));
		}
	}
	
	static function update_id_product_stripe ($id, $id_product, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE stripe 
				SET id_product = :id_product
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'id_product' => $id_product
			));
		}
	}
	
	static function update_id_price_stripe ($id, $id_price, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE stripe 
				SET id_price = :id_price
				WHERE id_user = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'id_price' => $id_price
			));
		}
	}
	
	static function update_nom_utilisateur ($id, $nom, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE utilisateur 
				SET nom = :nom
				WHERE id = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'nom' => $nom
			));
		}
	}
	
	static function update_prenom_utilisateur ($id, $prenom, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE utilisateur 
				SET prenom = :prenom
				WHERE id = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'prenom' => $prenom
			));
		}
	}
	
	static function update_email_utilisateur ($id, $email, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE utilisateur 
				SET email = :email
				WHERE id = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'email' => $email
			));
		}
	}
	
	static function update_phone_utilisateur ($id, $phone, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE utilisateur 
				SET phone = :phone
				WHERE id = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'phone' => $phone
			));
		}
	}
	
	static function update_pass_utilisateur ($id, $pass, $my_db) {

		if ($stmt = $my_db->prepare('
				UPDATE utilisateur 
				SET pass = :pass
				WHERE id = :id
			')) {
			$stmt->execute(array(
                'id' => $id,
                'pass' => $pass
			));
		}
    }

	
}