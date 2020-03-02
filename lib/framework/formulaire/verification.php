<?php
namespace Framework\Formulaire;

class Verification {
	protected $_erreur = false;

	function __construct () {

	}
	static function image_verification ($filename) {
		if (is_file($filename)) {
			return true;
		} else {
			return false;
		}
	}
}