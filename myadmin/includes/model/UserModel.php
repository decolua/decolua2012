<?php
class UserModel
{
    function __construct(){
        global $db;
        $this->db = $db;
    }
	
	public function getUserList($nStart, $nNumberPerPage){
		if(is_null($nStart)) {
			$nStart = 0;
		}	
		$nStart = ($nStart * $nNumberPerPage);
	
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM user ORDER BY user_id DESC LIMIT :nStart, " . $nNumberPerPage);
			$st->bindParam(':nStart', $nStart, PDO::PARAM_INT);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}	
	}
	
	public function countUser(){
		if($this->db) {
			$st = $this->db->prepare("SELECT COUNT(user_id) FROM user ");		
			$st->execute();
			return $st->fetchColumn();
		}			
	}		
	
	public function getUserById($user_id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM user WHERE user_id=:user_id");
			$st->bindParam(':user_id', $user_id);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}
	
	public function getUserByName($user_name){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM user_name WHERE name=:user_name");
			$st->bindParam(':user_name', $user_name);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}	
	
	public function insertUser($email, $user_name, $pass, $birthday, $country, $avatar, $sex, $fk_team_id, $cash){
		if($this->db){
			$szQuery = "INSERT INTO 
						user(email, user_name, pass, birthday, country, avatar, sex, reg_time, fk_team_id, cash) 
						VALUES (:email, :user_name, :pass, :birthday, :country, :avatar, :sex, :reg_time, :fk_team_id, :cash)";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':email', $email, PDO::PARAM_STR);
			$st->bindParam(':user_name', $user_name, PDO::PARAM_STR);	
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
	
	public function updateUser($user_id, $user_name, $short_name, $stadium, $avatar, $fans_num, $league_id){
		if($this->db){
		}
		else{
			throw new Exception("Category is not define!");
		}	
	}
	
	public function deleteUser($user_id){
		if($this->db){
			$szQuery = "DELETE FROM user WHERE user_id=:user_id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':user_id', $user_id, PDO::PARAM_INT);
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}		
	}
}
?>