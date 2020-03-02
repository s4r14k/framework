<?php
namespace framework\models;

class Messages {
    
    private $id_user = "";
    private $nombre_message = "";

	public function __construct($id_user, $my_db) {
	    
		$_id_user = filter_var($id_user, FILTER_VALIDATE_INT);
		$this->id_user = $_id_user;
		if ($stmt = $my_db->prepare('
				SELECT count(id_utilisateur) AS countMessage FROM message WHERE id_utilisateur = :_id_user
  			')) {
            $stmt->bindParam('_id_user', $_id_user, \PDO::PARAM_INT);
			$stmt->execute();
        	$this->nombre_message = $stmt->fetch(\PDO::FETCH_ASSOC);
		} else {
			$result =  "ERROR";
		}

		$stmt->closeCursor();
	}
	
	function getNombreMessage() {
	    return $this->nombre_message;
	}
	
	function getIdUser() {
	    return $this->id_user;
	}
	
	function getMessageWithLimit($my_db) {
		if ($stmt = $my_db->prepare('
			  SELECT m.contenu, m.date_message, u.prenom, u.email
			  FROM message m
			  LEFT JOIN utilisateur u
			  ON u.id = m.id_from
			  WHERE m.type = 0
			  AND m.id_utilisateur = :id
			  LIMIT 4
			')) {
			    $stmt->execute(array(
			        'id' => $this->id_user
			    ));
			  $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			  array_push($result, $this->nombre_message);
	           return $result;
	  } else {
		  echo "ERROR";
	  }
	    $stmt->closeCursor();

    }
    
    function setMessage($id, $contenu, $my_db) {
        if ($stmt = $my_db->prepare('
			  INSERT INTO message
			  SET id_utilisateur = :id_user, id_from = :id_from, contenu = :contenu, date_message = NOW(), type = 0
			')) {
			    $stmt->execute(array(
			        'id_user' => $id,
			        'id_from' => $this->id_user,
			        'contenu' => $contenu
			    ));
	  } else {
		  echo "ERROR";
	  }
	    $stmt->closeCursor();
    }
	
}

