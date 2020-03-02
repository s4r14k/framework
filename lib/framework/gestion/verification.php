<?php
namespace Framework\Gestion;

class Verification {
	protected $_erreur = false;

	function __construct () {
		$this->_erreur;
	}

	static function image_verification ($filename) {
		if (is_file($filename)) {
			return $filename;
		} else {
			return false;
		}
	}

	static function check_type ($type = NULL) {
		if (is_string($type)) {
			$retour = filter_var($type, FILTER_SANITIZE_STRING);
			if (strlen($retour) < 512) {
				return strip_tags(htmlspecialchars($retour));
			} else {
				return false;
			}
		} elseif (is_integer($type)) {
			$retour = filter_var($type, FILTER_VALIDATE_INT);
			if ($retour < 11024) {
				return htmlspecialchars($retour);
			} else {
				return false;
			}
		} else if (\preg_match("#^[a-z0-9._-]+[@%40][a-z0-9._-]{2,}\.[a-z]{2,4}$#",$type)) {
			$retour = filter_var($type, FILTER_VALIDATE_EMAIL);
			if (strlen($retour) < 512) {
				return $retour;
			} else {
				return false;
			}
		} else {
			return 'error to parse value';
		}
	}
}