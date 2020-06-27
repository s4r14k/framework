<?php
namespace framework\gestion;

class Insert {

    static function taxe ($id_taxe, $juridiction, $percentage, $my_db) {
        
	    if ($stmt = $my_db->prepare('
				INSERT INTO taxe (id_taxe, juridiction, percentage)
				VALUES (:id_taxe, :juridiction, :percentage)
			')) {
			$stmt->execute(array(
				'id_taxe' => $id_taxe,
				'juridiction' => $juridiction,
				'percentage' => $percentage
			));
		}
	}

}