<?php
class LeagueController {

	private $_szAlias = "league";
	private $_szTitle = "League";
	private $_nNumberPerPage = 32;
	private function getLeagueModel() {
		$getLeagueModel =  new LeagueModel();
		return $getLeagueModel;
	}	
	
	public function getAll() {
		$pData = $this->getLeagueModel()->getAllLeague();
		$pObject = new stdClass; 
		$pObject->leagues = $pData;
		echo json_encode($pObject);
	}
}

?>