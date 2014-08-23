<?php
class CashModel
{
    function __construct(){
        global $db;
        $this->db = $db;
    }

	public function getCashByUserId($user_id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM cash WHERE user_id=:user_id ORDER BY cash_id DESC");
			$st->bindParam(':user_id', $user_id, PDO::PARAM_INT);
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
						`cash`($szFieldList) 
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
	
	public function update($cash_id, $pObject){
		if($this->db){
			$szBind = "";		
		
			$lsData = get_object_vars($pObject);
			if (count($lsData) == 0)
				return;
			
			foreach($lsData as $key => $value)	{
				$szBind .= "$key =:$key," ;
			}		
			$szBind = substr($szBind, 0, strlen($szBind) - 1);
		
			$szQuery = "UPDATE `cash` SET $szBind WHERE cash_id = :cash_id LIMIT 1";
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
			$st->bindParam(':cash_id', $cash_id);
			
			$st->execute();	
		}
		else{
			throw new Exception("Category is not define!");
		}	
	}
}
?>