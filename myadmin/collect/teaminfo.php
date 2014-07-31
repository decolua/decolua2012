<?php require_once('../includes/config.php');

$szProxy = "http://sstruyen.com/skybet/proxy.php?url=";

$pTeamModel = new TeamModel();

$szUrl = "http://data.7m.cn/matches_data/473/en/index.shtml";
$szUrl = base64_encode($szUrl);
$szData = file_get_contents($szProxy . $szUrl);	 

$szBuffer = GetDataByPattern($szData, "spt_message,</body>");

$lsSplit = explode("</a>", $szBuffer);
set_time_limit(0);
for ($i=0; $i<count($lsSplit) - 1; $i++){
	set_time_limit(0);
	$szId = GetDataByPattern($lsSplit[$i], '/team_data/,/en/in');
	$szUrl = "http://data.7m.cn/sdt.aspx?t=1&id=" . $szId . "&e=2&f=0";
	
	$szUrl = base64_encode($szUrl);
	$szHtml = file_get_contents($szProxy . $szUrl);	
	$team_name = GetDataByPattern($szHtml, "team_name = ',||,';");
	$team_stadium = GetDataByPattern($szHtml, "team_stadium = ',||,';");		
	$team_stadium = str_replace("\\","", $team_stadium);
	$team_city = GetDataByPattern($szHtml, "team_city = ',||,';");
	$team_city = str_replace("\\","", $team_city);
	$szTeamLogo = GetDataByPattern($szHtml, "team_logo = ,;");		
	if ($szTeamLogo == "1")		
		$szLogoUrl = "http://data.7m.cn/team_data/" . $szId . "/logo_Img/club_logo.jpg";	
	else		
		$szLogoUrl = "http://data.7m.cn/team_data/" . $szId . "/logo_Img/club_logo.gif";			
		
	$pTeamInfo = $pTeamModel->getTeamByName($team_name);	
	if ($pTeamInfo == null){		
		$team_short_name = "";		
		$team_avatar = "";		
		$team_fans_num = 0;		
		$league_id = 473;
		$nTeamId = $pTeamModel->insertTeam($team_name, $team_short_name, $team_city, $team_stadium, $team_avatar, $team_fans_num, $league_id);		
		//$szImgData = file_get_contents($szLogoUrl);		
		$szLogoUrl = base64_encode($szLogoUrl); 
		$szImgData = file_get_contents($szProxy . $szLogoUrl);			
		file_put_contents("../../images/team/" . $nTeamId . ".png", $szImgData);	}}
?>