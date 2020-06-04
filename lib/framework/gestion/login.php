<?php
namespace framework\gestion;

class Login {
	function __construct () {

	}
	static function check_user ($email, $password, $check) {

		if((password_verify($password, $check['pass']) === true) and ($email == $check['email'])) {
			
			// Get the user-agent string of the user
			$user_browser = $_SERVER['HTTP_USER_AGENT'];
            
            // XSS protection as we might print this value
            $user_id = preg_replace("/[^0-9]+/", "", $check['id']);
                    
            $_SESSION['user_id'] = $check['id'];
            
            // $_SESSION['profile_user'] = $check['image1'];

            // XSS protection as we might print this value
            $email = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $check['email']);
                           
			$_SESSION['email'] = $email;
			
			// $_SESSION['role'] = $check['role'];

			$_SESSION['username'] = $check['nom'].' '.$check['prenom'];
                         
            $_SESSION['login_string'] = password_hash($check['pass'], PASSWORD_BCRYPT);    
                                     
            return true;

		} elseif (!(password_verify($password, $check['pass']))) {
			return false;
        } 
	}

	static function check_login ($my_db) {

		if (isset($_SESSION['user_id'], $_SESSION['email'], $_SESSION['login_string'])) {
			$user_id = $_SESSION['user_id'];
			$login_string = $_SESSION['login_string'];
			$email = $_SESSION['email'];
			
			// Récupère la chaîne user-agent de l’utilisateur		
			$user_browser = $_SERVER['HTTP_USER_AGENT'];

			if ($req = $my_db->prepare("SELECT pass FROM utilisateur WHERE id = :id LIMIT 1")) {
			
				// Lie "$user_id" aux paramètres.
				$req->bindParam('id', $user_id);
				$req->execute(); // Exécute la déclaration.

				//$req->store_result();
            	$donne = $req->fetch();
			
            	if ($req->rowCount() == 1) {
				
                	// Si l’utilisateur existe, récupère les variables dans le résultat
                	$password = $donne['pass'];
					$login_check = password_hash($login_string, PASSWORD_BCRYPT);
                
					if (password_verify($login_string, $login_check)) {
					// Connecté!!!!
						return true;
					} else {
						return false;
					}
			
				} else {
					// Pas connecté
					return false;
				}
			} else {
				return false;
			}
		}
	}

	static function sec_session_start() {
		$session_name = 'freesell_mada_sec_session'; // Attribue un nom de session
		$secure = SECURE;
		
		// Cette variable empêche Javascript d’accéder à l’id de session
		$httponly = true;
		// Force la session à n’utiliser que les cookies
		if (ini_set('session.use_only_cookies', 1) === FALSE) {
			header("Location: error/error.php?err=Could not initiate a safe session (ini_set)");
			exit();
		}
		// Récupère les paramètres actuels de cookies
		$cookieParams = session_get_cookie_params();
		session_set_cookie_params($cookieParams["lifetime"],
		$cookieParams["path"],
		$cookieParams["domain"],
		$secure,
		$httponly);
		// Donne à la session le nom configuré plus haut
		session_name($session_name);
		session_start(); // Démarre la session PHP
		session_regenerate_id(); // Génère une nouvelle session et efface la précédente
	}

	static function deconnexion () {

		$_SESSION = array();

		$params = session_get_cookie_params();

		setcookie(session_name(),'', time() - 42000,
		$params["path"],
		$params["domain"],
		$params["secure"],
		$params["httponly"]);

		session_destroy();

		exit;
	}
}