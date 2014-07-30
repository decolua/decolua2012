<?php
// Khong lay dc du lieu match
class Crawler{
	public $_szMatchInfoUrl = "http://data2.7m.cn/fixture_data/en_XXX.js";
	public $_szLiveBasicInfo = "http://ctc.7m.cn/datafile/fen.js";
	public $_szLiveDetailInfo = "http://ctc.7m.cn/datafile/csxl.js";
	public $_lsLeagueTable = array(166);
	public $_bLeageTable = true;
	
	// Proxy
	public $_szProxy = "http://sstruyen.com/skybet/proxy.php?url=";
	public $_bUseProxy = true;
	
	public function getInfoArray($szHtml, $szPattern, $bString = false){
		$szBuffer = trim(GetDataByPattern($szHtml, $szPattern));
		if (!$bString)
			$lsData = explode(",", $szBuffer);
		else
			$lsData = explode("','", $szBuffer);
		return $lsData;
	}
	
	public function mysub($szString){
		return substr($szString, 1, strlen($szString) - 2);
	}
	
	public function proxyGetContent($szUrl){
		if ($this->_bUseProxy == false)
			return file_get_contents($szUrl);
		
		$szUrlEncode = base64_encode($szUrl);
		return file_get_contents($this->_szProxy . $szUrlEncode);
	}
	
	public function my_explode($szPattern, $szString){
		$lsData = array();
		$j = 0;
		$bFlag = false;
		
		$lsSplit =  explode($szPattern, $szString);
		$nCount = count($lsSplit);
		for ($i=0; $i<$nCount; $i++){
			if (substr_count($lsSplit[$i], "'") % 2 == 1){
				$bFlag = !$bFlag;
				if ($bFlag == false){
					$lsData[$j] .= $lsSplit[$i];
					$j++;
					continue;
				}
			}			
		
			if ($bFlag == false){
				$lsData[$j] = $lsSplit[$i];
				$j++;
			}
			else{
				if (isset($lsData[$j]))
					$lsData[$j] .= $lsSplit[$i] . ",";
				else
					$lsData[$j] = $lsSplit[$i] . ",";
					
			}
		}
		return $lsData; 
	}	
	
	public function getMatchInfo($nDateIndex){
		$szUrl  = str_replace("XXX", $nDateIndex, $this->_szMatchInfoUrl . "?nocache=" . (1406344405530 + time()));
		$szHtml = $this->proxyGetContent($szUrl);	
		
		if (strlen($szHtml) > 255){
			$lsMatchId = $this->getInfoArray($szHtml, "live_bh_Arr,]||[,");
			$lsMatchTime = $this->getInfoArray($szHtml, "Start_time_Arr,]||[,", true);
			$lsLeagueId = $this->getInfoArray($szHtml, "Match_bh_Arr,]||[,");
			$lsLeagueName = $this->getInfoArray($szHtml, "Match_name_Arr2,]||[,", true);
			$lsLeagueShortName = $this->getInfoArray($szHtml, "Match_name_Arr,]||[,", true);
			$lsHomeId = $this->getInfoArray($szHtml, "Team_A_bh_Arr,]||[,");
			$lsHomeName = $this->getInfoArray($szHtml, "Team_A_Arr,]||[,", true);
			$lsAwayId = $this->getInfoArray($szHtml, "Team_B_bh_Arr,]||[,");
			$lsAwayName = $this->getInfoArray($szHtml, "Team_B_Arr,]||[,", true);
			
			$nCount = count($lsMatchId);
			$lsData = array();
			for ($i = 0; $i < $nCount; $i++){
				$pObject = new stdClass(); 
				$pObject->match_id = $lsMatchId[$i];
				$pObject->match_time = $lsMatchTime[$i];
				$pObject->league_id = $lsLeagueId[$i];
				$pObject->league_name = $lsLeagueName[$i];
				$pObject->league_short_name = $lsLeagueShortName[$i];
				$pObject->home_id = $lsHomeId[$i];
				$pObject->home_name = $lsHomeName[$i];
				$pObject->away_id = $lsAwayId[$i];				
				$pObject->away_name = $lsAwayName[$i];
				$lsData[$i] = $pObject;
			}
			return $lsData;
		}
	}
	
	public function getLiveBasicData(){
		$szHtml = $this->proxyGetContent($this->_szLiveBasicInfo . "?t=123&nocache=" . (1406344405530 + time()));
		$lsSplit = explode("sDt[", $szHtml);
		
		$lsBaseData = array();
		$j = 0;
		$nCount = count($lsSplit);
		for ($i=1; $i<$nCount; $i++){
			$szId = trim(GetDataByPattern($lsSplit[$i], ",]"));
			$szData = trim(GetDataByPattern($lsSplit[$i], "=[,||,]"));
			
			$lsData =  $this->my_explode(",", $szData);
			$pObject = new stdClass();
			$pObject->match_id = intval($szId);
			
			if (isset($lsData[16])){
				$pObject->league_id = intval($lsData[16]);
				if (!$this->_bLeageTable || in_array($pObject->league_id, $this->_lsLeagueTable)) {
					$pObject->league_short_name = $this->mysub($lsData[0]);
					$pObject->home_id = $lsData[9];
					$pObject->home_name = $this->mysub($lsData[2]);
					$pObject->away_id = $lsData[10];
					$pObject->away_name = $this->mysub($lsData[3]);
					$pObject->away_name = $this->mysub($lsData[3]);
					if (isset($lsData[20]))
						$pObject->handicap = $this->mysub($lsData[20]);
					else
						$pObject->handicap = $this->mysub($lsData[20]);

					$lsBaseData[$j++] = $pObject;
				}
			}
		}
		
		return $lsBaseData;
	}
	
	public function getLiveDetailData(){
		$szHtml = $this->proxyGetContent($this->_szLiveDetailInfo . "?t=123&nocache=" . (1406344405530 + time()));
		$lsSplit = explode("sDt2[", $szHtml);
		
		$lsBaseData = array();
		$j = 0;
		$nCount = count($lsSplit);
		for ($i=1; $i<$nCount; $i++){
			$szId = trim(GetDataByPattern($lsSplit[$i], ",]"));
			$szData = trim(GetDataByPattern($lsSplit[$i], "=[,||,]"));
			$lsData =  $this->my_explode(",", $szData);
			$pObject = new stdClass();
			$pObject->match_id = intval($szId);
			$pObject->match_status = intval($lsData[0]);
			$pObject->home_goals = intval($lsData[1]);
			$pObject->away_goals = intval($lsData[2]);
			if (isset($lsData[8]))
				$pObject->first_time = str_to_time($this->mysub($lsData[8]));
			else
				$pObject->first_time = "0000-00-00 00:00:00";
			$pObject->first_result = $this->mysub($lsData[6]);
			$pObject->second_time = $this->mysub($lsData[5]);
			if (isset($lsData[11])){
				$pObject->home_back = $this->mysub($lsData[11]);
				$pObject->away_back = $this->mysub($lsData[12]);
			}
			else{
				$pObject->home_back = "";
				$pObject->away_back = "";
			}
			$lsBaseData[$j++] = $pObject;
		}
		return $lsBaseData;
	}	
	
	public function getLiveData(){
		$pBaseData = $this->getLiveBasicData();
		$pDetailData = $this->getLiveDetailData();
		$lsData = array();
		$k = 0;
		
		$nCount = count($pBaseData);
		$nCount1 = count($pDetailData);
		
		for ($i=0; $i<$nCount; $i++){
			for ($j=0; $j<$nCount1; $j++){
				if ($pBaseData[$i]->match_id == $pDetailData[$j]->match_id){
					$pObject = new stdClass();
					$pObject->match_id = $pBaseData[$i]->match_id;
					$pObject->league_id = $pBaseData[$i]->league_id; 
					$pObject->league_short_name = $pBaseData[$i]->league_short_name;
					$pObject->home_id = $pBaseData[$i]->home_id;
					$pObject->home_name = $pBaseData[$i]->home_name;
					$pObject->away_id = $pBaseData[$i]->away_id;
					$pObject->away_name = $pBaseData[$i]->away_name;
					$pObject->away_name = $pBaseData[$i]->away_name;
					$pObject->handicap = $pBaseData[$i]->handicap;
					$pObject->match_status = $pDetailData[$j]->match_status;
					$pObject->home_goals = $pDetailData[$j]->home_goals;
					$pObject->away_goals = $pDetailData[$j]->away_goals;
					$pObject->first_time = $pDetailData[$j]->first_time;
					$pObject->first_result = $pDetailData[$j]->first_result;
					$pObject->second_time = $pDetailData[$j]->second_time;
					$pObject->home_back = $pDetailData[$j]->home_back;
					$pObject->away_back = $pDetailData[$j]->away_back;
					$lsData[$k++] = $pObject;
					break;
				}			
			}
		}
		return $lsData;
	}
};
?>