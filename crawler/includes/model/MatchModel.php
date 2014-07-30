<?php
class MatchModel
{
    function __construct(){
        global $db;
        $this->db = $db;
    }
	
	public function getMatchById($id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM `match` WHERE id=:id");
			$st->bindParam(':id', $id);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS); 
		}			
	}
	
	public function getLivingMatch(){
		if($this->db) {
			$st = $this->db->prepare("
				SELECT * FROM `match` WHERE (match_status > 0 AND match_status < 4) 
											OR (match_status = 17 AND match_handicap = '')");
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS); 
		}			
	}
	
	public function updateHandicap(){
		if($this->db){
			$szQuery = "UPDATE `match` SET
						home_goals = :home_goals,
						away_goals = :away_goals
						WHERE id = :id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':home_goals', $home_goals);
			$st->bindParam(':away_goals', $away_goals);
			$st->bindParam(':id', $id);
			$st->execute();	
		}
		else{
			throw new Exception("Category is not define!");
		}	
	}
	
	public function insert($pObject){
		if($this->db){
			$lsData = get_object_vars($pObject);
			
			$szFieldList = "";
			$szBindList = "";
			foreach($lsData as $key => $value)	{
				$szFieldList .= $key . ',';
				$szBindList .= ':' . $key . ',';
			}				

			$szFieldList = substr($szFieldList, 0, strlen($szFieldList) - 1);
			$szBindList = substr($szBindList, 0, strlen($szBindList) - 1);
			
			$szQuery = "INSERT INTO 
						`match`($szFieldList) 
						VALUES ($szBindList)";
			$st = $this->db->prepare($szQuery);	

			$lsValue = array();
			$i = 0;
			foreach($lsData as $key => $value)	{
				$lsValue[$i] = $value;
				if (is_string($value))
					$st->bindParam(":$key" , $lsValue[$i], PDO::PARAM_STR);
				else
					$st->bindParam(":$key", $lsValue[$i]);
				$i++;
			}
			
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}
		return $this->db->lastInsertId(); 	
	}	
	
	public function insertMatch($league_id, $team_home_id, $team_away_id, $match_home_goals, $match_away_goals, $match_first_result, $match_first_time, $match_second_time, $match_handicap, $match_home_back, $match_away_back, $match_status, $m7_id){
		if($this->db){
			$szQuery = "INSERT INTO 
						`match`(league_id, team_home_id, team_away_id, match_home_goals, match_away_goals, match_first_result, match_first_time, match_second_time, match_handicap, match_home_back, match_away_back, match_status, m7_id) 
						VALUES (:league_id, :team_home_id, :team_away_id, :match_home_goals, :match_away_goals, :match_first_result, :match_first_time, :match_second_time, :match_handicap, :match_home_back, :match_away_back, :match_status, :m7_id)";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':league_id', $league_id);
			$st->bindParam(':team_home_id', $team_home_id);	
			$st->bindParam(':team_away_id', $team_away_id);
			$st->bindParam(':match_home_goals', $match_home_goals);
			$st->bindParam(':match_away_goals', $match_away_goals);
			$st->bindParam(':match_first_result', $match_first_result, PDO::PARAM_STR);
			$st->bindParam(':match_first_time', $match_first_time, PDO::PARAM_STR);
			$st->bindParam(':match_second_time', $match_second_time, PDO::PARAM_STR);
			$st->bindParam(':match_handicap', $match_handicap, PDO::PARAM_STR);
			$st->bindParam(':match_home_back', $match_home_back, PDO::PARAM_STR);
			$st->bindParam(':match_away_back', $match_away_back, PDO::PARAM_STR);
			$st->bindParam(':match_status', $match_status);
			$st->bindParam(':m7_id', $m7_id);
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}
		return $this->db->lastInsertId(); 	
	}
	
	public function updateMatchStatus($id, $status){
		if($this->db){ 
			$szQuery = "UPDATE `match` SET
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
	
	public function updateMatchGoals($id, $home_goals, $away_goals){
		if($this->db){
			$szQuery = "UPDATE `match` SET
						home_goals = :home_goals,
						away_goals = :away_goals
						WHERE id = :id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':home_goals', $home_goals);
			$st->bindParam(':away_goals', $away_goals);
			$st->bindParam(':id', $id);
			$st->execute();	
		}
		else{
			throw new Exception("Category is not define!");
		}	
	}	
	
	public function deleteMatch($id){
		if($this->db){
			$szQuery = "DELETE FROM `match` WHERE id=:id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':id', $id, PDO::PARAM_INT);
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}		
	}
	
	public function visibleMatch($id){
		if($this->db){
			$szQuery = "UPDATE `match` SET
						visibile = 1 - visibile
						WHERE id = :id";
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