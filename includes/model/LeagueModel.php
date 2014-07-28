<?php
class LeagueModel
{
    function __construct(){
        global $db;
        $this->db = $db;
    }
	
	public function getAllLeague(){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM league ORDER BY league_id DESC");
			$st->bindParam(':nStart', $nStart, PDO::PARAM_INT);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}		
	}	
	
	public function getLeagueList($nStart, $nLeaguePerPage){
		if(is_null($nStart)) {
			$nStart = 0;
		}	
		$nStart = ($nStart * $nLeaguePerPage);
	
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM league ORDER BY league_id DESC LIMIT :nStart, " . $nLeaguePerPage);
			$st->bindParam(':nStart', $nStart, PDO::PARAM_INT);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}	
	}
	
	public function countLeague(){
		if($this->db) {
			$st = $this->db->prepare("SELECT COUNT(league_id) FROM league ");		
			$st->execute();
			return $st->fetchColumn();
		}			
	}	
	
	public function getLeagueById($league_id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM league WHERE league_id=:league_id");
			$st->bindParam(':league_id', $league_id);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}
	
	public function getLeagueByName($league_name){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM league WHERE league_name=:league_name");
			$st->bindParam(':league_name', $league_name);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}	
	
	public function insertLeague($league_name, $league_short_name, $nation_id){
		if($this->db){
			$szQuery = "INSERT INTO 
						league(league_name, league_short_name, nation_id) 
						VALUES (:league_name, :league_short_name, :nation_id)";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':league_name', $league_name, PDO::PARAM_STR);
			$st->bindParam(':league_short_name', $league_short_name, PDO::PARAM_STR);
			$st->bindParam(':nation_id', $nation_id);	
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}
		return $this->db->lastInsertId(); 	
	}
	
	public function updateLeague($league_id, $league_name, $nation_id){
		if($this->db){
			$szQuery = "UPDATE league SET
						league_name = :league_name,
						nation_id = :nation_id 
						WHERE league_id = :league_id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':league_name', $league_name, PDO::PARAM_STR);
			$st->bindParam(':nation_id', $nation_id, PDO::PARAM_INT);	
			$st->bindParam(':league_id', $league_id, PDO::PARAM_INT);
			$st->execute();	
		}
		else{
			throw new Exception("Category is not define!");
		}	
	}
	
	public function deleteLeague($league_id){
		if($this->db){
			$szQuery = "DELETE FROM league WHERE league_id=:league_id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':league_id', $league_id, PDO::PARAM_INT);
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}		
	}
	
	public function visibleLeague($league_id){
		if($this->db){
			$szQuery = "UPDATE league SET
						league_visibile = 1 - league_visibile
						WHERE league_id = :league_id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':league_id', $league_id, PDO::PARAM_INT);
			$st->execute();	
		}
		else{
			throw new Exception("Category is not define!");
		}	
	}	
}
?>