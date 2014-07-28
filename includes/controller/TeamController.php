<?php
class TeamController {

	private $_szAlias = "team";
	private $_szTitle = "Team";
	private $_nNumberPerPage = 32;
	private function getTeamModel() {
		$getTeamModel =  new TeamModel();
		return $getTeamModel;
	}	
	
	public function getAll() {
		$pData = $this->getTeamModel()->getAllTeam();
		
		$nCount = count($pData);
		for ($i=0; $i<$nCount; $i++)
		{
			$pData[$i]->team_avatar = "http://footballchallenger.net/images/team/" . $pData[$i]->team_id . ".png";
		}
		
		$pObject = new stdClass; 
		$pObject->teams = $pData;
		echo json_encode($pObject);
	}
}

?>