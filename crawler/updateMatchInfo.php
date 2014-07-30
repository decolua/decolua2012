<?php		
	include("7m.php");		
	include("includes/config.php");		
	$pCrawler = new Crawler();		
	$pTeamModel = new TeamModel();
	$p7mModel = new M7Model();
	$pMatchModel = new MatchModel();
	
	// Init Crawler 
	$pCrawler->_bUseProxy = false;
	
	// Fetch Live Data
	$pMatchData = $pCrawler->getLiveData();
	
	// Query Live Data
	$pDBMatch = $pMatchModel->getLivingMatch();
	
	$nDBCount = count($pDBMatch);
	echo $nDBCount . " ";
	$nMatchCount = count($pMatchData);
	echo $nMatchCount . " ";
	
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
				
				if ($pDBMatch[$i]->match_second_time == "" && $pMatchData[$j]->second_time != "")	
					$pObject->match_second_time = $pMatchData[$j]->second_time;					
				
				if ($pDBMatch[$i]->match_handicap == "" && $pMatchData[$j]->handicap != ""){
					$pObject->match_handicap = $pMatchData[$j]->handicap;
					$pObject->match_home_back = $pMatchData[$j]->home_back;				
					$pObject->match_away_back = $pMatchData[$j]->away_back;					
				}

				if ($pDBMatch[$i]->match_status != $pMatchData[$j]->match_status)
					$pObject->match_status = $pMatchData[$j]->match_status;
								
				$pMatchModel->update($pDBMatch[$i]->match_id, $pObject);
				break;
			}
		}
	}
?>