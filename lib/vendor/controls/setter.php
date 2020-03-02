<?php
namespace vendor\controls;

class Setter extends \framework\gestion\manager {
	private $_nom;
	private $_prenom;
	private $_email;
	private $_phone;
	private $_pass;
	private $_role;

	function __construct ($nom = "", $prenom = "", $email = "", $phone = "", $pass = "", $role = "") {
		$this->_nom = filter_var($nom, FILTER_SANITIZE_STRING);
		$this->_prenom = filter_var($prenom, FILTER_SANITIZE_STRING);
		$this->_email = filter_var($email, FILTER_SANITIZE_STRING);
		$this->_phone = (int) filter_var($phone, FILTER_VALIDATE_INT);
		$this->_pass = filter_var($pass, FILTER_SANITIZE_STRING);
		$this->_role = filter_var($role, FILTER_VALIDATE_INT);

	}
	
	function set ($image1, $image2, $my_db) {
		return self::set_client_admin($this->_nom, $this->_prenom, $this->_email, $this->_phone, $this->_pass, $this->_role, $image1, $image2, $my_db);
	}
	
	function facture ($nom, $link, $titulaire, $validation, $etat, $my_db, $ref) {
		self::set_facture($nom, $link, $titulaire, $validation, $etat, $my_db, $ref);
	}
	
	static function modif_validation ($id, $value, $my_db) {
		self::update_validation_facture ($id, $value, $my_db);
	}

	static function modif_etat ($id, $value, $my_db) {
		self::update_etat_facture ($id, $value, $my_db);
	}
}








