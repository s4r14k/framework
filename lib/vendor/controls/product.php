<?php
namespace vendor\controls;

class Product extends \framework\gestion\product {
	private $_nom;
	private $_id_fournisseur;
	private $_quantite;
	private $_date_creation;
	//private $_photo;
    private $_id_categorie;
    private $_id_prix;
    private $_etat;

	function __construct ($nom = "", $id_fournisseur = "", $quantite = "", $date_creation = "", $id_categorie = "", $id_prix = "", $etat ="") {
		$this->_nom = filter_var($nom, FILTER_SANITIZE_STRING);
		$this->_id_fournisseur = filter_var($id_fournisseur, FILTER_SANITIZE_STRING);
		$this->_quantite = filter_var($quantite, FILTER_SANITIZE_STRING);
		$this->_date_creation = (int) filter_var($date_creation, FILTER_VALIDATE_INT);
		//$this->_photo = filter_var($photo, FILTER_SANITIZE_STRING);
        $this->_id_categorie = filter_var($id_categorie, FILTER_VALIDATE_INT);
        $this->_id_prix = filter_var($id_prix, FILTER_VALIDATE_INT);
        $this->_etat = filter_var($etat, FILTER_VALIDATE_INT);

	}
	// ($nom, $prenom, $email, $phone, $pass, $role, $cin, $occupation, $disponnibilite, $date_formation, $img1, $img2, $my_db)
	function product ($brut, $commission, $net, $image1, $image2, $my_db) {
		self::set_product($this->_nom, $this->_id_fournisseur, $this->_quantite, $this->_date_creation, $this->_id_categorie,$this->_etat, $image1, $image2, $brut, $commission, $net, $my_db);
	}
	// ($nom, $prenom, $email, $phone, $pass, $role, $raison_social, $objet_social, $adresse, $nif, $stat, $rcs, $img1, $img2, $my_db)
/*	function startup ($image1, $image2, $raison_social, $objet_social, $adresse, $nif, $stat, $rcs, $img1, $img2, $my_db) {
		self::set_startup($this->_nom, $this->_id_fournisseur, $this->_quantite, $this->_date_creation, $this->_photo, $this->_id_categorie, $raison_social, $objet_social, $adresse, $nif, $stat, $rcs, $image1, $image2, $my_db);
	}*/
}


 
 




