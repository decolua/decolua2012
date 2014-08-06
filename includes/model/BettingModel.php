<?php
class BettingModel
{
    function __construct(){
        global $db;
        $this->db = $db;
    }
	
	public function getBettingById($id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM betting WHERE id=:id");
			$st->bindParam(':id', $id);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}
	
	public function getBettingByIdList($szId){
		if($this->db) {
			$st = $this->db->prepare("SELECT betting_id, betting_status FROM betting WHERE betting_id IN ($szId)");
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}	
	
	public function getBettingByMatchId($match_id, $betting_status){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM betting WHERE match_id=:match_id AND betting_status=:betting_status");
			$st->bindParam(':match_id', $match_id, PDO::PARAM_INT);
			$st->bindParam(':betting_status', $betting_status, PDO::PARAM_INT);
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
						`betting`($szFieldList) 
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
	
	public function update($betting_id, $pObject){
		if($this->db){
			$szBind = "";		
		
			$lsData = get_object_vars($pObject);
			if (count($lsData) == 0)
				return;
			
			foreach($lsData as $key => $value)	{
				$szBind .= "$key =:$key," ;
			}		
			$szBind = substr($szBind, 0, strlen($szBind) - 1);
		
			$szQuery = "UPDATE `betting` SET $szBind WHERE betting_id = :betting_id";
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
			$st->bindParam(':betting_id', $betting_id);
			
			$st->execute();	
		}
		else{
			throw new Exception("Category is not define!");
		}	
	}	
	
	public function deleteBetting($id){
		if($this->db){
			$szQuery = "DELETE FROM betting WHERE id=:id";
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