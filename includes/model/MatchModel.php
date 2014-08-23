<?php
class MatchModel
{
    function __construct(){
        global $db;
        $this->db = $db;
    }
	
	public function getMatchById($match_id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM `match` WHERE match_id=:match_id");
			$st->bindParam(':match_id', $match_id);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}
	
	public function getMatchInTimeRange(){
		$CachedData = apc_fetch("getMatchInTimeRange");
		if ($CachedData !== false){
			//return $CachedData;
		}
		if($this->db) {
			$st = $this->db->prepare(
				'SELECT match_id, league_id, team_home_id, team_away_id, match_home_goals, match_away_goals, match_first_time, match_first_result, match_first_time, match_second_time, match_status FROM `match` WHERE ADDTIME(match_first_time, "24:00:00") > NOW() AND match_status <> 17');
			$st->execute();
			$lsData = $st->fetchAll(PDO::FETCH_CLASS);
			apc_add("getMatchInTimeRange", $lsData, 120);
			return $lsData;	
		}	
	}	
	
	public function getLivingMatch(){
		if($this->db) {
			$st = $this->db->prepare(
				"SELECT match_id, league_id, team_home_id, team_away_id, match_home_goals, match_away_goals, match_first_result, match_first_time, match_second_time, match_status FROM `match` WHERE match_status > 0 AND match_status < 4");
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS); 
		}	
	}
	
	public function getUpComingMatch(){
		if($this->db) {
			$st = $this->db->prepare(
				"SELECT match_id, league_id, team_home_id, team_away_id, match_home_goals, match_away_goals, match_first_time, match_handicap, match_home_back, match_away_back, match_status FROM `match` WHERE match_status = 17");
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS); 
		}	
	}	
	
	public function getMatchByIdList($szId){
		if($this->db) {
			$st = $this->db->prepare("SELECT match_id, league_id, team_home_id, team_away_id, match_home_goals, match_away_goals, match_first_time, match_handicap, match_home_back, match_away_back, match_status FROM `match` WHERE match_id IN ($szId)");
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
						WHERE id =:id LIMIT 1";
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