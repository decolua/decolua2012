<?php
class MatchController {

	private function getMatchModel() {
		$getMatchModel =  new MatchModel();
		return $getMatchModel;
	}	
	
	public function getLiving() {
		$pData = $this->getMatchModel()->getLivingMatch();
		$nCount = count($pData);
		for ($i=0; $i<$nCount; $i++){
			$pData[$i]->match_first_time .= " +08:00";
			$pData[$i]->match_second_time .= " +08:00";
		}
		$pObject = new stdClass; 
		$pObject->matches = $pData;
		echo json_encode($pObject);  
	}
	
	public function getUpComing() {
		$pData = $this->getMatchModel()->getUpComingMatch();
		$nCount = count($pData);
		for ($i=0; $i<$nCount; $i++){
			$pData[$i]->match_first_time .= " +08:00";
			$pData[$i]->match_second_time .= " +08:00";
		}
		$pObject = new stdClass; 
		$pObject->matches = $pData;
		echo json_encode($pObject);  
	}
	
	public function pay(){
	}
}

?>