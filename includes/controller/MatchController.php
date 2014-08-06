<?php
class MatchController {

	private function getMatchModel() {
		$getMatchModel =  new MatchModel();
		return $getMatchModel;
	}	
	private function getBettingModel() {
		$getBettingModel =  new BettingModel();
		return $getBettingModel;
	}		
	private function getUserModel() {
		$getUserModel =  new UserModel();
		return $getUserModel;
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
		$match_id = intval($_GET["match_id"]);
		
		if ($match_id < 1)
			return;
		
		$pMatch = $this->getMatchModel()->getMatchById($match_id);
		//if ($pMatch == null || $pMatch[0]->match_status < 4 || $pMatch[0]->match_status == 17)
		//	return;
		
		$lsBetting = $this->getBettingModel()->getBettingByMatchId($match_id, 0);
		
		// Payment
		$nCount = count($lsBetting);
		for ($i=0; $i<$nCount; $i++){
			$objBet = new stdClass;
			$nCash = $this->calCash($lsBetting[$i], $pMatch[0]);
			if ($nCash > 0){
				$this->getUserModel()->updateCash($lsBetting[$i]->user_id, $nCash);	
				$objBet->betting_status = 1;		
			}
			else {
				$objBet->betting_status = 2;		
			}
			$nBetId = $this->getBettingModel()->update($lsBetting[$i]->betting_id, $objBet);
		}	
	}
	
	public function calCash($pBetting, $pMatch){
		$nHomeGoals = $pMatch->match_home_goals;
		$nAwayGoals = $pMatch->match_away_goals;
		$nBettingCash = $pBetting->betting_cash;
		$szOddsTitle = $pBetting->odds_title;
		
		if ($szOddsTitle[0] == "c"){
			if ($nHomeGoals != intval($szOddsTitle[2]) || $nAwayGoals != intval($szOddsTitle[3]))
				return 0;
				
			$nRet = $nBettingCash * $this->genCorrectScore($pMatch->match_handicap, $pMatch->match_home_back, $pMatch->match_away_back, $nHomeGoals, $nAwayGoals);
			
			return $nRet;
		}
		if ($szOddsTitle[0] == "h"){
		}
		if ($szOddsTitle[0] == "r"){
		}		
	}
	
	function genCorrectScore($nHandicap, $nHomeBack, $nAwayBack, $nHomeGoals, $nAwayGoals){
		$nMagic = 0.05;
		$nOdd = $nHomeGoals - $nAwayGoals;
		$nAbs = abs($nOdd);
		if ($nAbs == 0)
			$lsBack = array(9, 5.5, 16);
		else if ($nAbs == 1)
			$lsBack = array(7, 9, 28);
		else if ($nAbs == 2)
			$lsBack = array(11, 18, 80);
		else if ($nAbs == 3)
			$lsBack = array(23, 53);
		else if ($nAbs == 4)
			$lsBack = array(35);
			
		$nIndex = 0;
		if ($nHomeGoals > $nAwayGoals)
			$nIndex = $nAwayGoals;
		else
			$nIndex = $nHomeGoals;
		
		// Money Back
		$nMoneyBack = $lsBack[$nIndex];
		
		// Calculate Percent 1
		$nHalfBack = ($nHomeBack + $nAwayBack) / 2;
		$nPercent = ($nHomeBack - $nHalfBack) / $nHalfBack;
		$nPlus1 = $nMoneyBack * $nPercent;
		
		// Calculate Percent 2
		$nPercent = abs($nHandicap * $nMagic);
		$nPlus2 = $nMoneyBack * $nPercent;	
		
		if ($nHandicap * $nOdd > 0)
			$nMoneyBack += $nPlus2 * 1.5 * (abs($nOdd) + 1);
		else if ($nHandicap * $nOdd < 0)
			$nMoneyBack -= $nPlus2;
		else
			$nMoneyBack += abs($nPlus2) + (abs($nHandicap) * 1.5);
			
		$nMoneyBack += $nPlus1;		
		
		if ($nHandicap * $nOdd < 0 && abs($nHandicap) > abs($nOdd * 4)){
			$nMoneyBack = $lsBack[$nIndex] + (abs($nHandicap) - abs($nOdd * 4)) * (0.6);
		}				

		return round($nMoneyBack);
	}		
}

?>