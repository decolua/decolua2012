<?php
class NationModel
{
    function __construct(){
        global $db;
        $this->db = $db;
    }
	
	public function getNationById($id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM nation WHERE id=:id");
			$st->bindParam(':id', $id);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}
	
	public function getNationByName($name){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM nation WHERE name=:name");
			$st->bindParam(':name', $name);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}	
	
	public function insertNation($name){
		if($this->db){
			$szQuery = "INSERT INTO 
						nation(name) 
						VALUES (:name,)";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':name', $name, PDO::PARAM_STR);
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}
		return $this->db->lastInsertId(); 	
	}
	
	public function updateNation($id, $name){
		if($this->db){
			$szQuery = "UPDATE nation SET
						name = :name 
						WHERE id = :id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':name', $name, PDO::PARAM_STR);
			$st->bindParam(':id', $id, PDO::PARAM_INT);
			$st->execute();	
		}
		else{
			throw new Exception("Category is not define!");
		}	
	}
	
	public function deleteNation($id){
		if($this->db){
			$szQuery = "DELETE FROM nation WHERE id=:id";
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