<?php
class MatchModel
{
    function __construct(){
        global $db;
        $this->db = $db;
    }
	
	public function getMatchById($id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM match WHERE id=:id");
			$st->bindParam(':id', $id);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}
	
	public function getLivingMatch(){
		if($this->db) {
			$st = $this->db->prepare(
				"SELECT livematch.*,team_name as team_away_name FROM livematch,team WHERE team_away_id=team_id");
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS); 
		}	
	}
	
	public function insertMatch($fk_home_id, $fk_away_id, $status, $start_time, $home_goals	, $away_goals, $fk_league_id){
		if($this->db){
			$szQuery = "INSERT INTO 
						match(fk_home_id, fk_away_id, status, start_time, home_goals, away_goals, fk_league_id) 
						VALUES (:fk_home_id, :fk_away_id, :status, :start_time, :home_goals, :away_goals, fk_league_id)";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':fk_home_id', $fk_home_id);
			$st->bindParam(':fk_away_id', $fk_away_id);	
			$st->bindParam(':status', $status);
			$st->bindParam(':start_time', $start_time, PDO::PARAM_STR);
			$st->bindParam(':home_goals', $home_goals);
			$st->bindParam(':away_goals', $away_goals);
			$st->bindParam(':fk_league_id', $fk_league_id);
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}
		return $this->db->lastInsertId(); 	
	}
	
	public function updateMatchStatus($id, $status){
		if($this->db){
			$szQuery = "UPDATE match SET
						status = :status
						WHERE id = :id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':status', $status);
			$st->bindParam(':id', $id);
			$st->execute();	
		}
		else{
			throw new Exception("Category is not define!");
		}	
	}
	
	public function deleteMatch($id){
		if($this->db){
			$szQuery = "DELETE FROM match WHERE id=:id";
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