<?php

class SoccerInfo{
	// Soccer Info
	public $_szLeague;
	public $_szHome;
	public $_szAway;
	public $_nSoccerId;
	public $_szTime;
	
	// Odd
	public $_szAsiaOdd;
	public $_szHomeOdd;
	public $_szDrawOdd;
	public $_szAwayOdd;
	
	// Goal Odd
	public $_lsGoalOdd;
}

class Crawler{
	
	public 	$_lsSoccerInfo;
	
	private $_szSkyBetHandiCapUrl = "http://www.skybet.com/football/betType/handicap-betting?dp=";
	private $_szGoalOddUrl = "http://www.skybet.com/football/champions-league/event/";
	
	public function getSkyBetSoccerInfo($szTime = ""){
		$szHtml = file_get_contents($this->_szSkyBetHandiCapUrl);
		
		$lsSplit = explode("mktgrp ", $szHtml);
		if (count($lsSplit) < 2)
			return;
			
		$szBuffer = $lsSplit[1];
		
		$lsLeague = explode("section-head l2", $szBuffer);
		
		for ($i=1; $i<count($lsLeague); $i++){
			$szLeague = trim(GetDataByPattern($lsLeague[$i], ">,<"));
			echo $szLeague . "<br/>"; 
			
			$lsSoccer = explode("dd_evt_caption", $lsLeague[$i]);
			for ($j=1; $j<count($lsSoccer); $j++){
				$szSoccerId = trim(GetDataByPattern($lsSoccer[$j], '_,"'));
				//echo $szSoccerId . "<br/>";
				$szCombat = trim(GetDataByPattern($lsSoccer[$j], '>,<'));
				echo $szCombat . "<br/>";
			}
		}
	}
	
	public function getGoalOdd($nSoccerId){
		$szHtml = file_get_contents($this->_szSkyBetHandiCapUrl . $nSoccerId);
		
	}
}
?>