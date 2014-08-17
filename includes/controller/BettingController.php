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
	
	private function getOddsModel() {
		$getOddsModel =  new OddsModel();
		return $getOddsModel;
	}			
	
	public function bet() {
		if (!isset($_POST['user_id']) || intval($_POST['user_id']) == 0)
			return;

		if (!isset($_POST['user_token']) || $_POST['user_token'] == "")
			return;			

		if (!isset($_POST['match_id']) || intval($_POST['match_id']) == 0)
			return;	
			
		if (!isset($_POST['betting_cash']) || intval($_POST['betting_cash']) == 0)
			return;	
			
		if (!isset($_POST['odds_title']) || $_POST['odds_title'] == "")
			return;			

		// Check User 
		$pUser = $this->getUserModel()->getUserByIdAndToken($_POST['user_id'], $_POST['user_token']);
		if ($pUser == null || $_POST['betting_cash'] > $pUser[0]->user_cash)
			return;
			
		// Check Match 
		$pMatch = $this->getMatchModel()->getMatchById(intval($_POST['match_id']));
		if ($pMatch == null || 
			$pMatch[0]->match_status != 17 ||
			$pMatch[0]->match_handicap == null)
			return;			
	
		// Insert Bet
		$objBet = new stdClass;
		$objBet->user_id = $_POST['user_id'];
		$objBet->match_id = $_POST['match_id'];
		$objBet->odds_title = $_POST['odds_title'];
		$objBet->betting_cash = $_POST['betting_cash'];
		$objBet->betting_time = date("Y-m-d h:i:s");
		$nBetId = $this->getBettingModel()->insert($objBet);
		
		// Update Cash
		$pInfo = new stdClass;
		$pInfo->user_cash = $pUser[0]->user_cash - $_POST['betting_cash'];
		$this->getUserModel()->update($_POST['user_id'], $pInfo);

		// Update OddsMode
		$pOdds = $this->getOddsModel()->getOddsByOddsTitle($_POST['match_id'], $_POST['odds_title']);
		if ($pOdds == null){
			$objOdd = new stdClass;
			$objOdd->match_id = $_POST['match_id'];
			$objOdd->odds_title = $_POST['odds_title'];
			$objOdd->betting_count = 1;
			$this->getOddsModel()->insert($objOdd);
		}
		else{
			$objOdd = new stdClass;
			$objOdd->betting_count = $pOdds[0]->betting_count + 1;
			$this->getOddsModel()->update($pOdds[0]->odds_id, $objOdd);		
		}
		
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
		if ($szListId == "")
			return;
			
		$szListId = rtrim($szListId, ",");
		$pBetting = $this->getBettingModel()->getBettingByIdList($szListId);
		$nCount = count($pBetting);
		for ($i=0; $i<$nCount; $i++){
			$pBetting[$i]->betting_time .= " " . SERVERUTC;
		}			
		$pObject = new stdClass; 
		$szTime = date("Y-m-d h:i:s " . SERVERUTC);
		$pObject->time = $szTime;		
		$pObject->bettings = $pBetting;
		echo json_encode($pObject); 		
	}
	
	public function byUser(){
		if (!isset($_GET['id']))
			return;	
			
		$user_id = intval($_GET['id']);
		$nTime = intval($_GET['t']);
		$szTime = date("Y-m-d h:i:s", $nTime);
			
		$pBetting = $this->getBettingModel()->getBettingByUserId($user_id, $szTime);		
		$nCount = count($pBetting);
		for ($i=0; $i<$nCount; $i++){
			$pBetting[$i]->betting_time .= " " . SERVERUTC;
		}		
		
		$pObject = new stdClass; 
		$pObject->time = time();
		$pObject->betting_list = $pBetting;	
		echo json_encode($pObject); 
	}	
}

?>