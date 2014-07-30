<?php
class TeamModel
{
    function __construct(){
        global $db;
        $this->db = $db;
    }
	
	public function getTeamById($id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM team WHERE id=:id");
			$st->bindParam(':id', $id);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}
	
	public function getTeamByName($team_name){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM team WHERE team_name=:team_name");
			$st->bindParam(':team_name', $team_name, PDO::PARAM_STR);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}	
	
	public function checkMatchByTeamName($home, $away){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM team WHERE name=:home OR name=:away");
			$st->bindParam(':home', $home, PDO::PARAM_STR);
			$st->bindParam(':away', $away, PDO::PARAM_STR);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}
	
	public function insertTeam($name, $short_name, $stadium, $avatar, $fans_num, $fk_league_id){
		if($this->db){
			$szQuery = "INSERT INTO 
						team(name, short_name, stadium, avatar, fans_num, fk_league_id) 
						VALUES (:name, :short_name, :stadium, :avatar, :fans_num, :fk_league_id)";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':name', $name, PDO::PARAM_STR);
			$st->bindParam(':short_name', $short_name, PDO::PARAM_STR);	
			$st->bindParam(':stadium', $stadium, PDO::PARAM_STR);
			$st->bindParam(':avatar', $avatar, PDO::PARAM_STR);
			$st->bindParam(':fans_num', $fans_num, PDO::PARAM_INT);
			$st->bindParam(':fk_league_id', $fk_league_id, PDO::PARAM_INT);
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}
		return $this->db->lastInsertId(); 	
	}
	
	public function updateTeam($id, $name, $short_name, $stadium, $avatar, $fans_num, $fk_league_id){
		if($this->db){
			$szQuery = "UPDATE team SET
						name = :name,
						short_name = :short_name,
						stadium = :stadium,
						avatar = :avatar,
						fans_num = :fans_num,
						fk_league_id = :fk_league_id
						WHERE id = :id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':name', $name, PDO::PARAM_STR);
			$st->bindParam(':short_name', $short_name, PDO::PARAM_STR);	
			$st->bindParam(':stadium', $stadium, PDO::PARAM_STR);
			$st->bindParam(':avatar', $avatar, PDO::PARAM_STR);
			$st->bindParam(':fans_num', $fans_num, PDO::PARAM_STR);
			$st->bindParam(':fk_league_id', $fk_league_id, PDO::PARAM_INT);
			$st->bindParam(':id', $id, PDO::PARAM_INT);
			$st->execute();	
		}
		else{
			throw new Exception("Category is not define!");
		}	
	}
	
	public function deleteTeam($id){
		if($this->db){
			$szQuery = "DELETE FROM team WHERE id=:id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':id', $id, PDO::PARAM_INT);
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}		
	}
	
	public function visibleTeam($id){
		if($this->db){
			$szQuery = "UPDATE team SET
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