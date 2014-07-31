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
	
	public function getLeagueById($id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM league WHERE id=:id");
			$st->bindParam(':id', $id);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}
	
	public function getLeagueByName($name){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM league WHERE name=:name");
			$st->bindParam(':name', $name);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}	
	
	public function insertLeague($name, $fk_nation_id){
		if($this->db){
			$szQuery = "INSERT INTO 
						league(name, fk_nation_id) 
						VALUES (:name, :fk_nation_id)";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':name', $name, PDO::PARAM_STR);
			$st->bindParam(':fk_nation_id', $fk_nation_id, PDO::PARAM_INT);	
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}
		return $this->db->lastInsertId(); 	
	}
	
	public function updateLeague($id, $name, $fk_nation_id){
		if($this->db){
			$szQuery = "UPDATE league SET
						name = :name,
						fk_nation_id = :fk_nation_id 
						WHERE id = :id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':name', $name, PDO::PARAM_STR);
			$st->bindParam(':fk_nation_id', $fk_nation_id, PDO::PARAM_INT);	
			$st->bindParam(':id', $id, PDO::PARAM_INT);
			$st->execute();	
		}
		else{
			throw new Exception("Category is not define!");
		}	
	}
	
	public function deleteLeague($id){
		if($this->db){
			$szQuery = "DELETE FROM league WHERE id=:id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':id', $id, PDO::PARAM_INT);
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}		
	}
	
	public function visibleLeague($id){
		if($this->db){
			$szQuery = "UPDATE league SET
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