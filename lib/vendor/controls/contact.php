<?php
namespace vendor\controls;

class Contact extends \framework\gestion\manager {
	private $_email;
	private $_sujet;
	private $_message;

	function __construct ($email = "", $sujet = "", $message = "") {
	    $this->_email = filter_var($email, FILTER_SANITIZE_STRING);
		$this->_sujet = (int) filter_var($sujet, FILTER_VALIDATE_INT);
		$this->_message = filter_var($message, FILTER_SANITIZE_STRING);

	}
	
	function contacter ($my_db) {
		self::set_contact($this->_email, $this->_sujet, $this->_message, $my_db);
	}
}

