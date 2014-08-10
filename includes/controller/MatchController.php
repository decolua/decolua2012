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
	
	public function getMatchListByIds() {
		if (!isset($_GET['ids']))
			return;	
			
		$lsMatchId = explode('|', $_GET['ids']);

		$nCount = count($lsMatchId);
		$szListId = "";
		for ($i=0; $i<$nCount; $i++){
			$szListId .= intval($lsMatchId[$i]) . ",";
		}
		if ($szListId == "")
			return;
			
		$szListId = rtrim($szListId, ",");
		$pMatch = $this->getMatchModel()->getMatchByIdList($szListId);			
		$nCount = count($pMatch);
		for ($i=0; $i<$nCount; $i++){
			$pMatch[$i]->match_first_time .= " +08:00";
			$pMatch[$i]->match_second_time .= " +08:00";
		}
		
		$pObject = new stdClass; 
		$pObject->matches = $pMatch;
		echo json_encode($pObject); 
	}
	
	public function pay(){
		$match_id = intval($_GET["match_id"]);
		
		if ($match_id < 1)
			return;
		
		$pMatch = $this->getMatchModel()->getMatchById($match_id);
		if ($pMatch == null || 
			$pMatch[0]->match_status < 4 || 
			$pMatch[0]->match_status == 17 ||
			$pMatch[0]->match_handicap == null)
			return;
		
		$lsBetting = $this->getBettingModel()->getBettingByMatchId($match_id, 0);
		
		// Payment
		$nCount = count($lsBetting);
		for ($i=0; $i<$nCount; $i++){
			$objBet = new stdClass;
			$nCash = $this->calCash($lsBetting[$i], $pMatch[0]);
			if ($nCash >= $lsBetting[$i]->betting_cash){
				$this->getUserModel()->updateCash($lsBetting[$i]->user_id, $nCash);	
				$objBet->betting_status = 1;		
			}
			else {
				$objBet->betting_status = 2;		
			}
			$objBet->betting_get = $nCash - $lsBetting[$i]->betting_cash;
			$nBetId = $this->getBettingModel()->update($lsBetting[$i]->betting_id, $objBet);
		}	
	}
	
	public function ret(){
		$match_id = intval($_GET["match_id"]);
		
		if ($match_id < 1)
			return;
		
		$pMatch = $this->getMatchModel()->getMatchById($match_id);
		if ($pMatch != 13 && $pMatch != 14)
			return;
		
		$lsBetting = $this->getBettingModel()->getBettingByMatchId($match_id, 0);
		
		// Payment
		$nCount = count($lsBetting);
		for ($i=0; $i<$nCount; $i++){
			$objBet = new stdClass;
			$nCash = $lsBetting[$i]->betting_cash;
			$this->getUserModel()->updateCash($lsBetting[$i]->user_id, $nCash);
			$objBet->betting_status = 3;
			$objBet->betting_get = 0;
			$nBetId = $this->getBettingModel()->update($lsBetting[$i]->betting_id, $objBet);
		}	
	}	
	
	public function calCash($pBetting, $pMatch){
		$nHomeGoals = $pMatch->match_home_goals;
		$nAwayGoals = $pMatch->match_away_goals;
		$nBettingCash = $pBetting->betting_cash;
		$szOddsTitle = $pBetting->odds_title;
		
		if ($szOddsTitle[0] == "m"){
			if ($szOddsTitle[2] == "h" && $nHomeGoals > $nAwayGoals){
				$nRet = $nBettingCash * $this->genMatchResult($pMatch->match_handicap, $pMatch->match_home_back, $pMatch->match_away_back, 0); 
				return $nRet;
			}
			if ($szOddsTitle[2] == "a" && $nHomeGoals < $nAwayGoals){
				$nRet = $nBettingCash * $this->genMatchResult($pMatch->match_handicap, $pMatch->match_home_back, $pMatch->match_away_back, 1); 
				return $nRet;
			}
			if ($szOddsTitle[2] == "d" && $nHomeGoals == $nAwayGoals){
				$nRet = $nBettingCash * $this->genMatchResult($pMatch->match_handicap, $pMatch->match_home_back, $pMatch->match_away_back, 2); 
				return $nRet;
			}
			return 0;
		}
		else if ($szOddsTitle[0] == "h"){
			if ($szOddsTitle[2] == "h"){
				$nRange = ($nHomeGoals + ($pMatch->match_handicap / 4)) - $nAwayGoals;
				if ($nRange == -0.25)
					return round($nBettingCash / 2);
				if ($nRange == 0)
					return $nBettingCash;
				if ($nRange == 0.25)
					return $nBettingCash + round($nBettingCash / 2);
				if ($nRange > 0)
					return ($nBettingCash + $nBettingCash * $pMatch->match_home_back / 100);
			}
			if ($szOddsTitle[2] == "a"){
				$nRange = $nAwayGoals - ($nHomeGoals + ($pMatch->match_handicap / 4));
				if ($nRange == -0.25)
					return round($nBettingCash / 2);
				if ($nRange == 0)
					return $nBettingCash;
				if ($nRange == 0.25)
					return $nBettingCash + round($nBettingCash / 2);					
				if ($nRange > 0)
					return round($nBettingCash + $nBettingCash * $pMatch->match_away_back / 100);
			}
			return 0;		
		}	
		else if ($szOddsTitle[0] == "c"){
			if ($nHomeGoals != intval($szOddsTitle[2]) || $nAwayGoals != intval($szOddsTitle[4]))
				return 0;
				
			$nRet = $nBettingCash * $this->genCorrectScore($pMatch->match_handicap, $pMatch->match_home_back, $pMatch->match_away_back, $nHomeGoals, $nAwayGoals);
			return $nRet;
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
	
	function genMatchResult($nHandicap, $nHomeBack, $nAwayBack, $nWin){
		$nIndex = abs($nHandicap);
		$nBase = 250;
		$nOdd = $nHomeBack - $nAwayBack;
		$nAbsHandicap = abs($nHandicap);
		
		if ($nWin == 0){
			if ($nHandicap <= 0){
				$lsMagic = array(0, -40, -60, -75, -90, -110, -125, -135, -138);
				$nMagic = -1.2;	
				if ($nAbsHandicap == 0)
					$nAbsHandicap = 0.9;
				$nMagic2 = 5 * abs($nOdd / 2) / $nAbsHandicap * 0.6;
				if ($nHomeBack < $nAwayBack)
					$nMagic2 = -$nMagic2;
			}
			else{
				$lsMagic = array(0, 40, 100, 160, 220, 290, 380, 460, 500);
				$nMagic = 120;	
				$nMagic2 = 5 * abs($nOdd / 2) * $nAbsHandicap;
				if ($nHomeBack < $nAwayBack)
					$nMagic2 = -$nMagic2 / 1.8;		
			}
		}
		else if ($nWin == 1){
			if ($nHandicap >= 0){
				$lsMagic = array(0, -40, -60, -75, -90, -110, -125, -135, -138);
				$nMagic = -1.2;	
				if ($nAbsHandicap == 0)
					$nAbsHandicap = 0.9;			
				$nMagic2 = 5 * abs($nOdd / 2) / $nAbsHandicap * 0.6;
				if ($nHomeBack > $nAwayBack)
					$nMagic2 = -$nMagic2;
			}
			else{
				$lsMagic = array(0, 40, 100, 160, 220, 290, 380, 460, 500);
				$nMagic = 120;	
				$nMagic2 = 5 * abs($nOdd / 2) * $nAbsHandicap;
				if ($nHomeBack > $nAwayBack)
					$nMagic2 = -$nMagic2 / 1.8;		
			}	
		}
		else{
			$lsMagic = array(0, 30, 50, 70, 100, 140, 190, 250, 320);
			$nBase = 300;	
			if ($nHandicap < 0){
				if ($nHomeBack < $nAwayBack){
					$nMagic = 100;	
					$nMagic2 = 5 * abs($nOdd / 2) * $nAbsHandicap / 1.6;
				}
				else{
					$nMagic = 30;	
					$nMagic2 = 5 * abs($nOdd / 2) / $nAbsHandicap;
					$nMagic2 = -$nMagic2 / 1.6;
				}
			}
			else if ($nHandicap > 0){
				if ($nHomeBack > $nAwayBack){
					$nMagic = 100;	
					$nMagic2 = 5 * abs($nOdd / 2) * $nAbsHandicap / 1.6;
				}
				else{
					$nMagic = 30;
					$nMagic2 = 5 * abs($nOdd / 2) / $nAbsHandicap;
					$nMagic2 = -$nMagic2 / 1.6;
				}	
			}
			else{
				$nMagic2 = 5 * abs($nOdd / 2) / 0.5;		
			}
		}
		
		if ($nIndex < 9){
			$nBack = $nBase + $lsMagic[$nIndex];
		}
		else{
			$nBack = $nBase + $lsMagic[8] + ($nIndex - 8) * $nMagic;
		}

		return round($nBack + $nMagic2) / 100;	
	}
}

?>