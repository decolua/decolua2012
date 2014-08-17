<?php	
	include("7m.php");		
	include("includes/config.php");		
	$pCrawler = new Crawler();		
	$pTeamModel = new TeamModel();
	$p7mModel = new M7Model();
	$pMatchModel = new MatchModel();
	$pLeagueModel = new LeagueModel();
	
	// Init Crawler 
	$pCrawler->_bUseProxy = true;
	$lsLeagueId = $pLeagueModel->getVisibleLeagueId();
	$pCrawler->_lsLeagueTable = $lsLeagueId;
	
	// Fetch Live Data
	$pMatchData = $pCrawler->getLiveData();
	
	// Query Live Data
	$pDBMatch = $pMatchModel->getLivingMatch();
	
	$nDBCount = count($pDBMatch);
	$nMatchCount = count($pMatchData);
	
	for ($i=0; $i<$nDBCount; $i++){
		for ($j=0; $j<$nMatchCount; $j++){ 
			if ($pDBMatch[$i]->m7_id == $pMatchData[$j]->match_id){
				$pObject = new stdClass();
				
				if ($pDBMatch[$i]->match_home_goals != $pMatchData[$j]->home_goals)
					$pObject->match_home_goals = $pMatchData[$j]->home_goals;
				
				if ($pDBMatch[$i]->match_away_goals != $pMatchData[$j]->away_goals)	
					$pObject->match_away_goals = $pMatchData[$j]->away_goals;
				
				if ($pDBMatch[$i]->match_first_result == "" && $pMatchData[$j]->first_result !="")	
					$pObject->match_first_result = $pMatchData[$j]->first_result;
				
				if ($pMatchData[$j]->match_status == 3 && $pDBMatch[$i]->match_second_time == "0000-00-00 00:00:00" && $pMatchData[$j]->second_time != "0000-00-00 00:00:00")	
					$pObject->match_second_time = $pMatchData[$j]->second_time;
				
				if ($pDBMatch[$i]->match_handicap == "" && $pMatchData[$j]->handicap != ""){
					$pObject->match_handicap = floatval($pMatchData[$j]->handicap) * 4;
					$pObject->match_home_back = floatval($pMatchData[$j]->home_back) * 100;	
					$pObject->match_away_back = floatval($pMatchData[$j]->away_back) * 100;	
				}

				if ($pDBMatch[$i]->match_status != $pMatchData[$j]->match_status){
					$pObject->match_status = $pMatchData[$j]->match_status;
					if ($pMatchData[$j]->match_status == 4 || $pMatchData[$j]->match_status == 8){
						$ctx = stream_context_create(array('http' => array('timeout' => 0 ))); 
						file_get_contents("http://footballchallenger.net/service.php?nav=match&action=pay&match_id=" . $pDBMatch[$i]->match_id, 0, $ctx); 
					}
				}
								
				$pMatchModel->update($pDBMatch[$i]->match_id, $pObject);
				break;
			}
		}
	}
?>