<?php

	function MyRound($x){
		return floor($x * 2) / 2;
	}

	function genCorrectScore($handicap, $home_back, $away_back, $home, $away){
		$nOdd = $home - $away;
		$nAbs = abs($home - $away);
		if ($nAbs == 0)
			$lsBack = array(9, 5.5, 16);	// 0-0; 1-1; 2-2
		else if ($nAbs == 1)
			$lsBack = array(7, 9, 28);		// 1-0;	2-1; 3-1
		else if ($nAbs == 2)
			$lsBack = array(11, 18, 80);	// 2-0; 3-1; 4-2
		else if ($nAbs == 3)
			$lsBack = array(23, 53);		// 3-0; 4-1
			
		$nIndex = 0;
		if ($home > $away)
			$nIndex = $away;
		else
			$nIndex = $home;
			
		$nMoneyBack = $lsBack[$nIndex];
		
		$total = $home_back + $away_back;
		$nPercent = $handicap * 0.015;
		
		if ($nOdd > 0){
			$home_back = $home_back + ($nPercent * $total);
			$away_back = $away_back - ($nPercent * $total);
		}
		else{
			$home_back = $home_back - ($nPercent * $total);
			$away_back = $away_back + ($nPercent * $total);
		
		}

		if ($handicap*$nOdd < 0 && abs($handicap/4) > abs($nOdd)) {
			$home_back = $home_back + ($nPercent * $total);
			$away_back = $away_back - ($nPercent * $total);		
			$nRet = ($nMoneyBack * $away_back / $home_back);
		}
		else{
			$nRet = $nMoneyBack * $home_back / $away_back;
		}
		
		return MyRound($nRet);
	}	

	

	$home_back = 90;
	$away_back = 45;		
	
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
			<td>4-1</td>
			<td>4-2</td>
			<td>0-0</td>
			<td>1-1</td>
			<td>2-2</td>
		</tr>';
	for ($i = 0; $i<12; $i++)
	{
		$handicap = $i;
		echo '<tr>
			<td> HOME </td>
			<td>' . ($handicap / 4) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 1, 0) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 2, 0) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 2, 1) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 3, 0) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 3, 1) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 3, 2) . '</td>
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
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 1, 4) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 2, 4) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 0, 0) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 1, 1) . '</td>
			<td>' . genCorrectScore($handicap, $home_back, $away_back, 2, 2) . '</td>
		</tr>';		
	}
	
	echo '</table>';
	
?>		
