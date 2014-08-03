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
	
	public function getUserByIdAndToken($user_id, $user_token){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM user WHERE user_id=:user_id AND user_token=:user_token");
			$st->bindParam(':user_id', $user_id);
			$st->bindParam(':user_token', $user_token);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}		
	
	public function getUserByEmail($user_email){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM user WHERE user_email=:user_email");
			$st->bindParam(':user_email', $user_email);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}	
	
	public function getUserByEmailAndPass($user_email, $user_pass)
	{
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM user WHERE user_email=:user_email AND user_pass=:user_pass");
			$st->bindParam(':user_email', $user_email, PDO::PARAM_STR);
			$st->bindParam(':user_pass', $user_pass, PDO::PARAM_STR);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
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
						`user`($szFieldList) 
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
	
	public function update($user_id, $pObject){
		if($this->db){
			$szBind = "";		
		
			$lsData = get_object_vars($pObject);
			if (count($lsData) == 0)
				return;
			
			foreach($lsData as $key => $value)	{
				$szBind .= "$key =:$key," ;
			}		
			$szBind = substr($szBind, 0, strlen($szBind) - 1);
		
			$szQuery = "UPDATE `user` SET $szBind WHERE user_id = :user_id";
			$st = $this->db->prepare($szQuery);		
			
			// Bind Param
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
			$st->bindParam(':user_id', $user_id);
			
			$st->execute();	
		}
		else{
			throw new Exception("Category is not define!");
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