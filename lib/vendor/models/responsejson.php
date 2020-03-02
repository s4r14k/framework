<?php
namespace Vendor\Models;

class ResponseJSON {
	private $_donnee;
	function __construct () {

	}
	static function encodeFichier ($donnee) {
		if (isset($donnee)) {
			try {
				// $data = array('response' => $donnee);
				$result = json_encode($donnee, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				return $result;
			} catch (\Exception $e) {
				die ('Erreur ' . $e->getMessage());
			}
		}
	}
	static function ecrireFichier ($donnee, $path) {
		if (isset($donnee)) {
			try {
				$file = fopen($path, 'w');
			} catch (\Exception $e) {
				die ('Erreur ' . $e->getMessage());
			}

			fwrite($file, self::encodeFichier($donnee));
			fclose($file);
		}
	}
}