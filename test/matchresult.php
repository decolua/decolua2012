<?php

// 0.05  0.2   0.1
// 0.05 * distance * handicap

function genMatchResult($nHandicap, $nHomeBack, $nAwayBack, $nWin){
	$nIndex = abs($nHandicap);
	$nBase = 250;
	$nOdd = $nHomeBack - $nAwayBack;
	$nAbsHandicap = abs($nHandicap);
	
	if ($nHandicap > 0){
		if ($nWin == 0)
			$nWin = 1;
		else if ($nWin == 1)
			$nWin = 0;
	}
	
	if ($nWin == 0){
		$lsMagic = array(0, -40, -60, -75, -90, -110, -125, -135, -138);
		$nMagic = -1.2;	
		$nMagic2 = - 5 * abs($nOdd / 2);
	}
	else if ($nWin == 1){
		$lsMagic = array(0, 40, 100, 150, 200, 250, 350, 400, 450);
		$nMagic = 110;	
		$nMagic2 = 5 * abs($nOdd / 2) * $nAbsHandicap;
	}
	else{
		$lsMagic = array(0, 30, 50, 70, 100, 140, 190, 250, 320);
		$nBase = 300;
		$nMagic = 60;
		$nMagic2 = 5 * abs($nOdd / 2) * $nAbsHandicap / 1.6;
	}
	
	
	if ($nIndex < 9){
		$nBack = $nBase + $lsMagic[$nIndex];
	}
	else{
		$nBack = $nBase + $lsMagic[8] + ($nIndex - 8) * $nMagic;
	}
	
	if ($nOdd * $nHandicap > 0){
		$nMagic2 = -$nMagic2;
	}
	
	return ($nBack + $nMagic2) / 100;
}

	echo
	'
	<table border="1">
		<tr>
			<td>Handicap</td>
			<td>Win</td>
			<td>Lose</td>
			<td>Draw</td>
		</tr>';
	for ($i = 0; $i<12; $i++)
	{
		$handicap = -$i;
		echo '<tr>
			<td>' . ($handicap / 4) . '</td>
			<td>' . genMatchResult($handicap, 80, 100, 0) . '</td>
			<td>' . genMatchResult($handicap, 80, 100, 1) . '</td>
			<td>' . genMatchResult($handicap, 80, 100, 2) . '</td>
		</tr>';
	}

?>