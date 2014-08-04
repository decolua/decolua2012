<?php
class ConfigController {

	private function getConfigModel() {
		$getConfigModel =  new ConfigModel();
		return $getConfigModel;
	}	
	
	public function start() {
		$nVersion = intval($_GET['ver']);
		
		$pData = $this->getConfigModel()->getConfig();
		$pObject = new stdClass; 
		
		$pObject->version = $pData[0]->version;
		if ($pData[0]->league > $nVersion)
			$pObject->league = "true";	
		if ($pData[0]->team > $nVersion)
			$pObject->team = "true";	
		if ($pData[0]->nation > $nVersion)
			$pObject->nation = "true";				
			
		echo json_encode($pObject);  
	}
}

?>