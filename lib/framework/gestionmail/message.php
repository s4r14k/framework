<?php
namespace Framework\GestionMail;

class Message {
	private $_to = "alphagroup@gmail.com";
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


}
