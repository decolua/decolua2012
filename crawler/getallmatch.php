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
			$pObject = new stdClass();
			$pObject->m7_match_id = $pMatchData[$i]->match_id;
			$pObject->m7_match_status = $pMatchData[$i]->match_status;
			$pObject->m7_crawler_status = 0;
			$pObject->match_id = 0;
			$p7mModel->insert($pObject);
			
			// Check Team
			$pHome = $pTeamModel->getTeamByName($pMatchData[$i]->home_name);
			$pAway = $pTeamModel->getTeamByName($pMatchData[$i]->away_name);
			if ($pHome != null && $pAway != null){
				$pObject = new stdClass();
				$pObject->league_id = intval($pMatchData[$i]->league_id);
				$pObject->team_home_id =  intval($pHome[0]->team_id);
				$pObject->team_away_id =  intval($pAway[0]->team_id);
				$pObject->match_home_goals = $pMatchData[$i]->home_goals;
				$pObject->match_away_goals = $pMatchData[$i]->away_goals;
				$pObject->match_first_result = $pMatchData[$i]->first_result;
				$pObject->match_first_time = $pMatchData[$i]->first_time;
				$pObject->match_second_time = $pMatchData[$i]->second_time;
				$pObject->match_handicap = $pMatchData[$i]->handicap;
				$pObject->match_home_back = $pMatchData[$i]->home_back;				
				$pObject->match_away_back = $pMatchData[$i]->away_back;
				$pObject->match_status = $pMatchData[$i]->match_status;	
				$pObject->m7_id = $pMatchData[$i]->match_id;			
				$pMatchModel->insert($pObject);			
			}
		}
	}
	
	// status
	// 1  : first half
	// 2  : between match
	// 3  : second half
	// 4  : finished
	// 13 : postponed
	// 15 : Undecided
	// 17 : waiting
?>