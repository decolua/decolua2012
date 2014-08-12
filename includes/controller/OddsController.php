<?php
class OddsController {
	private function getOddsModel() {
		$getOddsModel =  new OddsModel();
		return $getOddsModel;
	}		
	
	public function countOdds() {
		if (!isset($_GET["match_id"]) || intval($_GET["match_id"]) == 0){
			return;
		}
		$pOdds = $this->getOddsModel()->getOddsByMatchId(intval($_GET["match_id"]));
		$pRetObject = new stdClass; 
		$pRetObject->odds = $pOdds;		
		echo json_encode($pRetObject);
	}
}

?>