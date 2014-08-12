<?php
class OddsModel
{
    function __construct(){
        global $db;
        $this->db = $db;
    }
	
	public function getOddsByMatchId($match_id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM odds WHERE match_id=:match_id");
			$st->bindParam(':match_id', $match_id, PDO::PARAM_INT);
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS);
		}			
	}		
	
	public function getOddsByOddsTitle($match_id, $odds_title){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM odds WHERE match_id=:match_id AND odds_title=:odds_title");
			$st->bindParam(':match_id', $match_id, PDO::PARAM_INT);
			$st->bindParam(':odds_title', $odds_title, PDO::PARAM_STR);
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
						`odds`($szFieldList) 
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
	
	public function update($odds_id, $pObject){
		if($this->db){
			$szBind = "";		
		
			$lsData = get_object_vars($pObject);
			if (count($lsData) == 0)
				return;
			
			foreach($lsData as $key => $value)	{
				$szBind .= "$key =:$key," ;
			}		
			$szBind = substr($szBind, 0, strlen($szBind) - 1);
		
			$szQuery = "UPDATE `odds` SET $szBind WHERE odds_id = :odds_id LIMIT 1";
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
			$st->bindParam(':odds_id', $odds_id);
			
			$st->execute();	
		}
		else{
			throw new Exception("Category is not define!");
		}	
	}		
}
?>