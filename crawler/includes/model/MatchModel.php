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
	
	public function update($match_id, $pObject){
		if($this->db){
			$szBind = "";		
		
			$lsData = get_object_vars($pObject);
			if (count($lsData) == 0)
				return;
			
			foreach($lsData as $key => $value)	{
				$szBind .= "$key =:$key," ;
			}		
			$szBind = substr($szBind, 0, strlen($szBind) - 1);
		
			$szQuery = "UPDATE `match` SET $szBind WHERE match_id = :match_id";
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
			$st->bindParam(':match_id', $match_id);
			
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