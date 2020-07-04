<?php
namespace framework\formulaire;

class image extends verification {
	private $_path;
	private $_filename;

	static function add ($filename) {
		//self::image_verification($filename);
		$path = BASE_IMG.'/images/';
		$name = self::randomName();

		if(isset($filename) AND $filename['error'] == 0) {
			if($filename['size'] <= 10000000) {
				$extension_fichier = pathinfo($filename['name']);
				$extension_upload = strtolower($extension_fichier['extension']);
				$extension_autorise = array('jpg', 'png', 'gif', 'pdf', 'jpeg');
				$name .= '.'.$extension_upload;

				if(in_array($extension_upload, $extension_autorise)) {
					move_uploaded_file($filename['tmp_name'], $path . $name);

					return '/backoffice/images/'. $name;	
				} else {
					return false;
				}
			}
		}
	}

	function miniature ($filename) {
		return exif_thumbnail($filename);
	}

	function __get ($path) {
		if ($path == 'filename') {
			return $this->_filename;
		} else {
			return false;
		}
	}

	static function randomName() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_-';
		$name = array(); //remember to declare $name as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 28; $i++) {
			$n = rand(0, $alphaLength);
			$name[] = $alphabet[$n];
		}
		return implode($name); //turn the array into a string
	}
}