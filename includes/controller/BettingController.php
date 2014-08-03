<?php
class BettingController {

	private function getBettingModel() {
		$getBettingModel =  new BettingModel();
		return $getBettingModel;
	}
	
	private function getUserModel() {
		$getUserModel =  new UserModel();
		return $getUserModel;
	}	

	private function getMatchModel() {
		$getMatchModel =  new MatchModel();
		return $getMatchModel;
	}		
	
	public function bet() {
		if (!isset($_POST['user_id']) || intval($_POST['user_id']) == 0)
			return;

		if (!isset($_POST['user_token']) || $_POST['user_token'] == "")
			return;			

		if (!isset($_POST['match_id']) || intval($_POST['match_id']) == 0)
			return;			

		if (!isset($_POST['cash']) || intval($_POST['cash']) == 0)
			return;	

		if (!isset($_POST['odds_title']) || $_POST['odds_title'] == "")
			return;			

		// Check User 
		$pUser = $this->getUserModel()->getUserByIdAndToken($_POST['user_id'], $_POST['user_token']);
		if ($pUser == null || $_POST['cash'] > $pUser[0]->user_cash)
			return;
			
		// Check Match 
		$pMatch = $this->getMatchModel()->getMatchById(intval($_POST['match_id']));
		if ($pMatch == null || $pMatch[0]->match_status != 17)
			return;			
	
		// Insert Bet
		$objBet = new stdClass;
		$objBet->user_id = $_POST['user_id'];
		$objBet->match_id = $_POST['match_id'];
		$objBet->odds_title = $_POST['odds_title'];
		$objBet->betting_cash = $_POST['cash'];
		$nBetId = $this->getBettingModel()->insert($objBet);
		
		// Update Cash
		$pInfo = new stdClass;
		$pInfo->user_cash = $pUser[0]->user_cash - $_POST['cash'];
		$this->getUserModel()->update($_POST['user_id'], $pInfo);		
		
		// Return
		$pRetObject = new stdClass; 
		$pRetObject->result = "true";
		$pRetObject->betting_id = $nBetId;	
		echo json_encode($pRetObject);
	}
	
	public function getResult(){
		if (!isset($_GET['ids']) || $_GET['ids'] == 0)
			return;	
			
		$lsBettingId = explode('|', $_GET['ids']);

		$nCount = count($lsBettingId);
		$szListId = "";
		for ($i=0; $i<$nCount; $i++){
			$szListId .= intval($lsBettingId[$i]) . ",";
		}
		if ($szListId != "")
			$szListId .= '0';
			
		$pBetting = $this->getBettingModel()->getBettingByIdList($szListId);			
		$pObject = new stdClass; 
		$pObject->bettings = $pBetting;
		echo json_encode($pObject); 		
		
	}
}

?>