<?php
class M7Model
{
    function __construct(){
        global $db;
        $this->db = $db; 
    }
	
	public function get7mMatchById($m7_match_id){
		if($this->db) {
			$st = $this->db->prepare("SELECT * FROM m7 WHERE m7_match_id=:m7_match_id");
			$st->bindParam(':m7_match_id', $m7_match_id);
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
						m7($szFieldList) 
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
	
	public function insertM7($m7_match_id, $m7_match_status, $m7_crawler_status, $match_id){
		if($this->db){
			$szQuery = "INSERT INTO 
						m7(m7_match_id, m7_match_status, m7_crawler_status, match_id) 
						VALUES (:m7_match_id, :m7_match_status, :m7_crawler_status, :match_id)";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':m7_match_id', $m7_match_id);
			$st->bindParam(':m7_match_status', $m7_match_status);	
			$st->bindParam(':m7_crawler_status', $m7_crawler_status);
			$st->bindParam(':match_id', $match_id);
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}
		return $this->db->lastInsertId(); 	
	}
	
	
	public function deleteM7($m7_id){
		if($this->db){
			$szQuery = "DELETE FROM team WHERE m7_id=:m7_id";
			$st = $this->db->prepare($szQuery);		
			$st->bindParam(':m7_id', $m7_id, PDO::PARAM_INT);
			$st->execute();
		}
		else{
			throw new Exception("Category is not define!");
		}		
	}
}
?>