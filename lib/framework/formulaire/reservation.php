<?php
namespace Framework\Formulaire;

class Reservation {

	private $_name;
	private $_email;
	private $_phoneNumber;
	private $_dateDepart;
	private $_address = [];
	private $_message;
	private $_duree;

	function __construct ($name, $email, $phoneNumber = "", $dateDepart = "", $address = "", $message, $duree ="") {
		$this->_name = $name;
		$this->_email = $email;
		$this->_phoneNumber = $phoneNumber;
		$this->_dateDepart = $dateDepart;
		$this->_address = $address;
		$this->_message = $message;
		$this->_duree = $duree;
	}

	function __get ($name) {
		return "ERROR";
	}

	function envoyeSimpleEmail() {

		$mail = 'alphagroupcustomerservice@gmail.com';

		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
			$passage_ligne = "\r\n";
		} else {
			$passage_ligne = "\n";
		}

		$message_txt = $this->_message;

		//=====Création de la boundary
		$boundary = "-----=".md5(rand());
		//==========

		$sujet = "Nouveau Client: " . $this->_name;

		//=====Création du header de l'e-mail.
		$header = "From: \"WeaponsB\"<{$this->_email}>".$passage_ligne;
		$header.= "Reply-to: \"WeaponsB\" <{$mail}>".$passage_ligne;
		$header.= "MIME-Version: 1.0".$passage_ligne;
		$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
		//==========

		//=====Création du message.
		$message = $passage_ligne."--".$boundary.$passage_ligne;
		//=====Ajout du message au format texte.
		$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_txt;
		//==========
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		//==========

		//=====Envoi de l'e-mail.
		mail($mail,$sujet,$message,$header);
		//==========
		return true;
	}

	function envoyeEmailEtFichier($mail, $filename) {
		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
			$passage_ligne = "\r\n";
		} else{
			$passage_ligne = "\n";
		}

		//=====Lecture et mise en forme de la pièce jointe.
		$fichier   = fopen(BASE."/Web/PDF/{$filename}.pdf", "r");
		$attachement = fread($fichier, filesize(BASE."/Web/PDF/{$filename}.pdf"));
		$attachement = chunk_split(base64_encode($attachement));
		fclose($fichier);
		//==========

		//=====Création de la boundary.
		$boundary = "-----=".md5(rand());
		$boundary_alt = "-----=".md5(rand());
		//==========

		//=====Définition du sujet.
		$sujet = "Client: " . $this->_name;
		//=========

		//=====Création du header de l'e-mail.
		$header = "From: \"WeaponsB\"<test@test.fr>".$passage_ligne;
		$header.= "Reply-to: \"WeaponsB\" <{$mail}>".$passage_ligne;
		$header.= "MIME-Version: 1.0".$passage_ligne;
		$header.= "Content-Type: multipart/mixed;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
		//==========

		//=====Création du message.
		$message = $passage_ligne."--".$boundary.$passage_ligne;
		$message.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;
		$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;

		//=====Ajout du message au format texte.
		$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$this->_message.$passage_ligne;
		//==========

		$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;

		//=====On ferme la boundary alternative.
		$message.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;
		//==========

		$message.= $passage_ligne."--".$boundary.$passage_ligne;

		//=====Ajout de la pièce jointe.
		$message.= "Content-Type: text/PDF; name=\"{$filename}.pdf\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: base64".$passage_ligne;
		$message.= "Content-Disposition: attachment; filename=\"{$filename}.pdf\"".$passage_ligne;
		$message.= $passage_ligne.$attachement.$passage_ligne.$passage_ligne;
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne; 
		//========== 

		//=====Envoi de l'e-mail.
		mail($mail,$sujet,$message,$header);
		//==========
	}

} 
 
 
 
 
 
 
 
 
 
 
