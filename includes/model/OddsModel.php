<?php
class OddsModel
{
    function __construct(){
        global $db;
        $this->db = $db;
    }
	
	public function getOddsById($id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM odds WHERE id=:id");
			$st->bindParam(':id', $id);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}
	
	public function insertOdds($fk_match_id, $money_place, $money_back, $fk_type_id, $param1, $param2, $param3){
		if($this->db){
			$szQuery = "INSERT INTO 
						odds(fk_match_id, money_place, money_back, fk_type_id, param1, param2, param3) 
						VALUES (:fk_match_id, :money_place, :money_back, :fk_type_id, :param1, :param2, :param3)";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':fk_match_id', $fk_match_id);
			$st->bindParam(':money_place', $money_place);	
			$st->bindParam(':money_back', $money_back);
			$st->bindParam(':fk_type_id', $fk_type_id, PDO::PARAM_STR);
			$st->bindParam(':param1', $param1);
			$st->bindParam(':param2', $param2);
			$st->bindParam(':param3', $param3);
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}
		return $this->db->lastInsertId(); 	
	}
	
	public function deleteOdds($id){
		if($this->db){
			$szQuery = "DELETE FROM odds WHERE id=:id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':id', $id, PDO::PARAM_INT);
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}		
	}	
}
?>