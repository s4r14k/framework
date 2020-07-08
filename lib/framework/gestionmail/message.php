<?php
namespace framework\gestionmail;

class Message {

    static function set($id_to, $id_from, $body, $reason, $my_db) {
        if ($stmt = $my_db->prepare('
			  INSERT INTO messages
			  SET id_to = :id_to, id_from = :id_from, body = :body, reason = :reason, date_send = NOW()
			')) {
			    $stmt->execute(array(
			        'id_to' => $id_to,
			        'id_from' => $id_from,
			        'body' => $body,
			        'reason' => $reason
			    ));
	  } else {
		  echo "ERROR";
	  }
	    $stmt->closeCursor();
    }
}