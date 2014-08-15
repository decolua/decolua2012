<?php
class ServerController {
	public function getCurTime() {
		$pRetObject = new stdClass; 
		$pRetObject->time = time();
		echo json_encode($pRetObject);
		return;				
	}
	
	public function getCurTimeStr() {
		$pRetObject = new stdClass; 
		$szTime = date("Y-m-d h:i:s -12:00");
		$pRetObject->time = $szTime;
		echo json_encode($pRetObject);
		return;				
	}	
}

?>