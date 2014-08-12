<?php

	function my_round($x){
		return floor($x * 2) / 2;
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

	$nHandicap = 4;
	$home_back = 81;
	$away_back = 101;	
	//echo genCorrectScore($nHandicap, $home_back, $away_back, 1, 0);
	//return;
	
	echo
	'
	<table border="1">
		<tr>
			<td>Team</td>
			<td>Handicap</td>
			<td>1-0</td>
			<td>2-0</td>
			<td>2-1</td>
			<td>3-0</td>
			<td>3-1</td>
			<td>3-2</td>
			<td>4-0</td>
			<td>4-1</td>
			<td>4-2</td>
			<td>0-0</td>
			<td>1-1</td>
			<td>2-2</td>
		</tr>';
	for ($i = 0; $i<12; $i++)
	{
		$handicap = -$i;
		echo '<tr>
			<td> HOME </td>
			<td>' . ($handicap / 4) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 1, 0) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 2, 0) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 2, 1) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 3, 0) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 3, 1) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 3, 2) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 4, 0) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 4, 1) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 4, 2) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 0, 0) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 1, 1) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 2, 2) . '</td>
		</tr>';
		
		echo '<tr>
			<td> AWAY </td>
			<td>' . ($handicap / 4) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 0, 1) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 0, 2) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 1, 2) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 0, 3) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 1, 3) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 2, 3) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 0, 4) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 1, 4) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 2, 4) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 0, 0) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 1, 1) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 2, 2) . '</td>
		</tr>';		
	}
	
	echo '</table>';
	
?>		
