<?php
namespace framework\gestionmail;

class Mail {
	private $_to;
	private $_from;
	private $_name;
	private $_email;
	private $_body;

	function __construct ($name_, $from_, $body_) {
		$this->_name = 'Website Contact From:' . $name_;
		$this->_from = $from_;
		$this->_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: {$name_}\n\nEmail: {$from_}\n\nMessage:\n{$body_}";
	}

	function Envoyer () {
		$headers = "From: noreply@yourdomain.com\n";
		$headers .= "Reply-To: {$this->_to}";
		mail($this->_to, $this->_name, $this->_body, $headers);
		return true;
	}

	// Mail statut
	static function send_client_access ($prenom, $email, $pass) {

		$headers = 'From:EverReady.ai <wordpress@everready.ai>' . "\r\n";
		// $headers .= "Return-Path:wordpress@everready.ai" . "\r\n";
		$headers .= "X-Mailer: PHP" . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .=	"Content-Type: text/html; charset=utf-8" . "\r\n";
					
		$subject = "[EverReady.ai] - Information on your customer areas";
		
		$body = "<html><body>Hello {$prenom}, <br>Here is the information concerning to connect to your customer areas<br>Email : {$email}<br>Password : {$pass}<br></body></html>";
		return mail ($email, $subject, $body, $headers);
	}

	static function envoyer_confirmation_email ($email, $caractere) {

		$headers = 'From:EverReady.ai <wordpress@everready.ai>' . "\r\n";
		// $headers .= "Return-Path:hello@hedee.co" . "\r\n";
		$headers .= "X-Mailer: PHP" . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .=	"Content-Type: text/html; charset=utf-8" . "\r\n";
		// $headers .=	"Cc:sarikraf@gmail.com,claudia@diris.fr" . "\r\n";
					
		$subject = "Validate your email address";
		
		$body = "<html>
					<body>
						Welcome to EverReady,
						<br>Please click the button below to VALIDATE your email address and activate our account
						<br><a href='#'>Activate</a>
						<br>If the above button does not work, click on the link below or copy and paste it into your browser:
						<br><a href='#'>everready.ai</a>
					</body>
				</html>";

		return mail ($email, $subject, $body, $headers);
	}

	static function envoyer_pass_oublie ($email, $pass) {
		// $headers = 'From:bouya.koit@gmail.com\r\n';

		$headers = 'From:Hedee <hello@hedee.co>' . "\r\n";
		$headers .= "Return-Path:hello@hedee.co" . "\r\n";
		$headers .= "X-Mailer: PHP" . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .=	"Content-Type: text/html; charset=utf-8" . "\r\n";
		// $headers .=	"Cc:sarikraf@gmail.com,claudia@diris.fr" . "\r\n";

		// $headers .=	'Cc: bouya.koit@gmail.com,sarikraf@gmail.com' . "\r\n";
					
		$subject = "[HEDEE CO] - Mot de passe oublié";
		
		$body = "<html><body>Bonjour, <br><br>Votre mot de passe a été réinitialisé avec succès!<br>Voici votre identifiant ainsi que votre nouveau mot de passe :<br>Email : {$email}<br>Mot de passe : {$pass}<br><br>L’équipe Hedee</body></html>";
		return mail ($email, $subject, $body, $headers);
	}


	static function envoyer_mail_premium ($email) {
		// $headers = 'From:bouya.koit@gmail.com\r\n';

		$headers = 'From:Hedee <hello@hedee.co>' . "\r\n";
		$headers .= "Return-Path:hello@hedee.co" . "\r\n";
		$headers .= "X-Mailer: PHP" . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .=	"Content-Type: text/html; charset=utf-8" . "\r\n";
		// $headers .=	"Cc:sarikraf@gmail.com,claudia@diris.fr" . "\r\n";
					
		$subject = "[OFFRE PREMIUM] - Nouvelle Souscription";
		
		$body = "<html><body>Félicitation !<br> Votre souscription à l’offre PREMIUM a été effectuée avec succès. Vous pouvez maintenant bénéficier des services suivants : <br><ul><li>Recherche du meilleur prix en LIGNE et en MAGASIN</li><li>Démarche de remboursement</li><li>Aucune commission prélevée</li><li>Remboursement minimum de 50 euros/an</li><li>Assistance avant achat</li><li>Assistance service après-vente</li></ul><br>Merci pour votre confiance.<br>L’équipe Hedee</body></html>";
		return mail ($email, $subject, $body, $headers);
	}
	
	static function mail_type () {
		
	}


}
