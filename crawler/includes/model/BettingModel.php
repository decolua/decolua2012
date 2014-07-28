<?php
class BettingModel
{
    function __construct(){
        global $db;
        $this->db = $db;
    }
	
	public function getBettingById($id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM betting WHERE id=:id");
			$st->bindParam(':id', $id);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}
	
	public function insertBetting($fk_user_id, $fk_odds_id, $bet_cash){
		if($this->db){
			$szQuery = "INSERT INTO 
						betting(fk_user_id, fk_odds_id, bet_cash) 
						VALUES (:fk_user_id, :fk_odds_id, :bet_cash)";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':fk_user_id', $fk_user_id);
			$st->bindParam(':fk_odds_id', $fk_odds_id);	
			$st->bindParam(':bet_cash', $bet_cash);
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}
		return $this->db->lastInsertId(); 	
	}
	
	public function deleteBetting($id){
		if($this->db){
			$szQuery = "DELETE FROM betting WHERE id=:id";
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