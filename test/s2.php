<?php

	function my_round($x){
		return floor($x * 2) / 2;
	}

	function genMatchResult($nHandicap, $nHomeBack, $nAwayBack, $nHomeGoals, $nAwayGoals){
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

	$nHandicap = 0;
	$home_back = 100;
	$away_back = 100;	
	echo genMatchResult($nHandicap, $home_back, $away_back, 1, 0);

?>		
