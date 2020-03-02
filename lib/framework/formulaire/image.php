<?php
namespace framework\formulaire;

class image extends verification {
	private $_path;
	private $_filename;

	function __construct ($filename) {
		//self::image_verification($filename);
		$path = BASE_IMG.'/factures/';

		if(isset($filename) AND $filename['error'] == 0) {
			if($filename['size'] <= 10000000) {
				$extension_fichier = pathinfo($filename['name']);
				$extension_upload = strtolower($extension_fichier['extension']);
				$extension_autorise = array('jpg', 'png', 'gif', 'pdf', 'jpeg');

				if(in_array($extension_upload, $extension_autorise)) {
					move_uploaded_file($filename['tmp_name'], $path . $filename['name']);
					$this->_path =  $path . $filename['name'];	
					$this->_filename = '/factures/'. $filename['name'];			
				} else {
					echo "Error";
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
}