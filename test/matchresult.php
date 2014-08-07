<?php
// 	0.05  0.2   0.1
// 	0.05 * distance * handicap
//	$lsMagic = array(0, 30, 50, 70, 100, 140, 190, 250, 320);
//	$nBase = 300;
//	$nMagic = 60;
//	$nMagic2 = 5 * abs($nOdd / 2) * $nAbsHandicap / 1.6;

function genMatchResult($nHandicap, $nHomeBack, $nAwayBack, $nWin){
	$nIndex = abs($nHandicap);
	$nBase = 250;
	$nOdd = $nHomeBack - $nAwayBack;
	$nAbsHandicap = abs($nHandicap);
	
	if ($nWin == 0){
		if ($nHandicap < 0){
			$lsMagic = array(0, -40, -60, -75, -90, -110, -125, -135, -138);
			$nMagic = -1.2;	
			$nMagic2 = 5 * abs($nOdd / 2) / $nAbsHandicap * 0.6;
			if ($nHomeBack < $nAwayBack)
				$nMagic2 = -$nMagic2;
		}
		else{
			$lsMagic = array(0, 40, 100, 150, 200, 250, 350, 400, 450);
			$nMagic = 120;	
			$nMagic2 = 5 * abs($nOdd / 2) * $nAbsHandicap;
			if ($nHomeBack < $nAwayBack)
				$nMagic2 = -$nMagic2;		
		}
	}
	else if ($nWin == 1){
		if ($nHandicap > 0){
			$lsMagic = array(0, -40, -60, -75, -90, -110, -125, -135, -138);
			$nMagic = -1.2;	
			$nMagic2 = 5 * abs($nOdd / 2) / $nAbsHandicap * 0.6;
			if ($nHomeBack > $nAwayBack)
				$nMagic2 = -$nMagic2;
		}
		else{
			$lsMagic = array(0, 40, 100, 150, 200, 250, 350, 400, 450);
			$nMagic = 120;	
			$nMagic2 = 5 * abs($nOdd / 2) * $nAbsHandicap;
			if ($nHomeBack > $nAwayBack)
				$nMagic2 = -$nMagic2;		
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
				$nMagic = 15;	
				$nMagic2 = 5 * abs($nOdd / 2) / $nAbsHandicap;
				$nMagic2 = -$nMagic2;			
			}
		}
		else{
			if ($nHomeBack > $nAwayBack){
				$nMagic = 100;	
				$nMagic2 = 5 * abs($nOdd / 2) * $nAbsHandicap / 1.6;
			}
			else{
				$nMagic = 15;	
				$nMagic2 = 5 * abs($nOdd / 2) / $nAbsHandicap;
				$nMagic2 = -$nMagic2;			
			}	
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

	echo
	'
	<table border="1">
		<tr>
			<td>Handicap</td>
			<td>Win</td>
			<td>Lose</td>
			<td>Draw</td>
		</tr>
		';

	for ($i = 0; $i<12; $i++)
	{
		$handicap = -$i;
		echo '<tr>
			<td>' . ($handicap / 4) . '</td>
			<td>' . genMatchResult($handicap, 98, 86, 0) . '</td>
			<td>' . genMatchResult($handicap, 98, 86, 1) . '</td>
			<td>' . genMatchResult($handicap, 98, 86, 2) . '</td>
		</tr>';
	}	
?>