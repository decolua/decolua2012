<?php
class UserModel
{
    function __construct(){
        global $db;
        $this->db = $db;
    }
	
	public function getUserById($id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM user WHERE id=:id");
			$st->bindParam(':id', $id);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}
	
	public function getUserByName($name){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM user WHERE name=:name");
			$st->bindParam(':name', $name);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}	
	
	public function insertUser($email, $name, $pass, $birthday, $country, $avatar, $sex, $fk_team_id, $cash){
		if($this->db){
			$szQuery = "INSERT INTO 
						user(email, name, pass, birthday, country, avatar, sex, reg_time, fk_team_id, cash) 
						VALUES (:email, :name, :pass, :birthday, :country, :avatar, :sex, :reg_time, :fk_team_id, :cash)";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':email', $email, PDO::PARAM_STR);
			$st->bindParam(':name', $name, PDO::PARAM_STR);	
			$st->bindParam(':pass', $pass, PDO::PARAM_STR);
			$st->bindParam(':birthday', $birthday, PDO::PARAM_STR);
			$st->bindParam(':country', $country, PDO::PARAM_INT);
			$st->bindParam(':avatar', $avatar, PDO::PARAM_STR);	
			$st->bindParam(':sex', $sex, PDO::PARAM_INT);
			$st->bindParam(':reg_time', $reg_time, PDO::PARAM_STR);
			$st->bindParam(':fk_team_id', $fk_team_id, PDO::PARAM_INT);
			$st->bindParam(':cash', $cash, PDO::PARAM_INT);			
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}
		return $this->db->lastInsertId(); 	
	}
	
	public function updateUser($id, $name, $short_name, $stadium, $avatar, $fans_num, $league_id){
		if($this->db){
		}
		else{
			throw new Exception("Category is not define!");
		}	
	}
	
	public function deleteUser($id){
		if($this->db){
			$szQuery = "DELETE FROM user WHERE id=:id";
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