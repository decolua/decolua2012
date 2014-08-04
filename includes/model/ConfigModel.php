<?php
class ConfigModel
{
    function __construct(){
        global $db;
        $this->db = $db;
    }
	
	public function getConfig(){
		if($this->db) {
			$st = $this->db->prepare(
				"SELECT * FROM `config`");
			$st->execute();
			return $st->fetchAll(PDO::FETCH_CLASS); 
		}		
	}
	
	public function updateConfig($szName){
		if($this->db){
			$szQuery = "UPDATE config SET
						$szName = version + 1,
						version = version + 1";
			$st = $this->db->prepare($szQuery);	
			$st->execute();	
		}
		else{
			throw new Exception("Category is not define!");
		}
	}
}