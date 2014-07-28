<?php
class TeamModel
{
    function __construct(){
        global $db;
        $this->db = $db;
    }
	
	public function getTeamList($nStart, $nTeamPerPage){
		if(is_null($nStart)) {
			$nStart = 0;
		}	
		$nStart = ($nStart * $nTeamPerPage);
	
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM team,league WHERE team.league_id=league.league_id ORDER BY team_id DESC LIMIT :nStart, " . $nTeamPerPage);
			$st->bindParam(':nStart', $nStart, PDO::PARAM_INT);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}	
	}
	
	public function countTeam(){
		if($this->db) {
			$st = $this->db->prepare("SELECT COUNT(team_id) FROM team ");		
			$st->execute();
			return $st->fetchColumn();
		}			
	}	
	
	public function getTeamById($team_id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM team WHERE team_id=:team_id");
			$st->bindParam(':team_id', $team_id);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}
	
	public function getTeamByName($team_name){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM team WHERE team_name=:team_name");
			$st->bindParam(':team_name', $team_name);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}	
	
	public function insertTeam($team_name, $team_short_name, $team_city, $team_stadium, $team_avatar, $team_fans_num, $league_id){
		if($this->db){
			$szQuery = "INSERT INTO 
						team(team_name, team_short_name, team_city, team_stadium, team_avatar, team_fans_num, league_id) 
						VALUES (:team_name, :team_short_name, :team_city, :team_stadium, :team_avatar, :team_fans_num, :league_id)";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':team_name', $team_name, PDO::PARAM_STR);
			$st->bindParam(':team_short_name', $team_short_name, PDO::PARAM_STR);	
			$st->bindParam(':team_city', $team_city, PDO::PARAM_STR);	
			$st->bindParam(':team_stadium', $team_stadium, PDO::PARAM_STR);
			$st->bindParam(':team_avatar', $team_avatar, PDO::PARAM_STR);
			$st->bindParam(':team_fans_num', $team_fans_num);
			$st->bindParam(':league_id', $league_id);
			$st->execute();
			return $this->db->lastInsertId(); 	
		}
		else{
			throw new Exception("Category is not define!");
		}
	}
	
	public function updateTeam($team_id, $team_name, $team_short_name, $team_city, $team_stadium, $team_avatar, $team_fans_num, $league_id){
		if($this->db){
			$szQuery = "UPDATE team SET
						team_name = :team_name,
						team_short_name = :team_short_name,
						team_city = :team_city,
						team_stadium = :team_stadium,
						team_avatar = :team_avatar,
						team_fans_num = :team_fans_num,
						league_id = :league_id
						WHERE team_id = :team_id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':team_name', $team_name, PDO::PARAM_STR);
			$st->bindParam(':team_short_name', $team_short_name, PDO::PARAM_STR);	
			$st->bindParam(':team_city', $team_city, PDO::PARAM_STR);	
			$st->bindParam(':team_stadium', $team_stadium, PDO::PARAM_STR);
			$st->bindParam(':team_avatar', $team_avatar, PDO::PARAM_STR);
			$st->bindParam(':team_fans_num', $team_fans_num, PDO::PARAM_STR);
			$st->bindParam(':league_id', $league_id, PDO::PARAM_INT);
			$st->bindParam(':team_id', $team_id, PDO::PARAM_INT);
			$st->execute();	
		}
		else{
			throw new Exception("Category is not define!");
		}	
	}
	
	public function deleteTeam($team_id){
		if($this->db){
			$szQuery = "DELETE FROM team WHERE team_id=:team_id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':team_id', $team_id, PDO::PARAM_INT);
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}		
	}
	
	public function visibleTeam($team_id){
		if($this->db){
			$szQuery = "UPDATE team SET
						team_visibile = 1 - team_visibile
						WHERE team_id = :team_id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':team_id', $team_id);
			$st->execute();	
		}
		else{
			throw new Exception("Category is not define!");
		}	
	}	
}
?>