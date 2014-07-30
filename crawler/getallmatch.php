<?php		
	include("7m.php");		
	include("includes/config.php");		
	$pCrawler = new Crawler();		
	$pTeamModel = new TeamModel();
	$p7mModel = new M7Model();
	$pMatchModel = new MatchModel();
	
	// Init Crawler 
	$pCrawler->_bUseProxy = false;
	$pMatchData = $pCrawler->getLiveData();
	
	$nCount = count($pMatchData);
	for ($i=0; $i<$nCount; $i++){
		$rs = $p7mModel->get7mMatchById($pMatchData[$i]->match_id);
		if ($rs == null){
			$p7mId = $p7mModel->insertM7($pMatchData[$i]->match_id, $pMatchData[$i]->match_status, 0, 0);
			
			// Check Team
			$pHome = $pTeamModel->getTeamByName($pMatchData[$i]->home_name);
			$pAway = $pTeamModel->getTeamByName($pMatchData[$i]->away_name);
			if ($pHome != null && $pAway != null){
				$pMatchModel->insertMatch(
						0, intval($pHome[0]->team_id), intval($pAway[0]->team_id), $pMatchData[$i]->home_goals,
						$pMatchData[$i]->away_goals, $pMatchData[$i]->first_result, $pMatchData[$i]->first_time, 
						$pMatchData[$i]->second_time, $pMatchData[$i]->handicap, $pMatchData[$i]->home_back, $pMatchData[$i]->away_back, $pMatchData[$i]->match_status, $pMatchData[$i]->match_id);
			}
		}
	}
	
	// status
	// 17 : waiting
	// 2  : first half
	// 3  : second half
	// 4  : finished

?>