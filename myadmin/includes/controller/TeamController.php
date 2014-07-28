<?php
class TeamController {
	
	private $_szAlias = "team";
	private $_szTitle = "Team";
	
	private $_nNumberPerPage = 32;

	private function getTeamModel() {
		$getTeamModel =  new TeamModel();
		return $getTeamModel;
	}	
	
	private function getLeagueModel() {
		$getLeagueModel =  new LeagueModel();
		return $getLeagueModel;
	}		

	public function start() {
		$nPage = 0;
		if (isset($_GET['page']))
			$nPage = intval($_GET['page']);
			
		$dataList = $this->getTeamModel()->getTeamList($nPage, 32);	
		$dataTotal = $this->getTeamModel()->countTeam();
		$nPageTotal = floor($dataTotal/$this->_nNumberPerPage);
		header("Cache-Control: no-cache, must-revalidate");	
		
		$i = 0;
		$lsTitle[$i++] = '<th class="title"><a href="#">Name</a></th>';
		$lsTitle[$i++] = '<th class="title"><a href="#">Short Name</a></th>';
		$lsTitle[$i++] = '<th class="title"><a href="#">City</a></th>';
		$lsTitle[$i++] = '<th class="title"><a href="#">Stadium</a></th>';
		$lsTitle[$i++] = '<th class="title" align="center"><a href="#">Avatar</a></th>';
		$lsTitle[$i++] = '<th class="title"><a href="#">Number Of Fans</a></th>';
		$lsTitle[$i++] = '<th class="title"><a href="#">League</a></th>';
		$lsTitle[$i++] = '<th class="title" width="10"><a href="#">Visible</a></th>';
		$lsTitle[$i++] = '<th class="title" width="10"><a href="#">Edit</a></th>';
		$lsTitle[$i++] = '<th class="title" width="10"><a href="#">Del</a></th>';
		
		for ($i=0; $i<count($dataList); $i++){
			$j = 0;
			$lsData[$i][$j++] = '<td>' . ($i + 1) . '</td>';
			$lsData[$i][$j++] = '<td align="center"><input id="cb5" name="cid[]" value="5" onclick="" type="checkbox"></td>';		
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->team_name . '</td>';
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->team_short_name . '</td>';
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->team_city . '</td>';
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->team_stadium . '</td>';
			$lsData[$i][$j++] = '<td align="center"><img src="/images/team/' . $dataList[$i]->team_id . '.png" style="height:50px"/></td>';
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->team_fans_num . '</td>';
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->league_name . '</td>';
			$lsData[$i][$j++] = '<td align="center">' . $dataList[$i]->team_visible . '</td>';
			$lsData[$i][$j++] = '<td align="center"><a href="index.php?nav=' . $this->_szAlias . '&action=edit&id=' . $dataList[$i]->team_id  . '" title="Sửa">Edit	</a></td>';
			$lsData[$i][$j++] = '
				<td align="center">
					<a href="javascript:void(0);" onclick="confirmDelete(\'index.php?nav=' . $this->_szAlias . '&action=del&id='. $dataList[$i]->team_id  .'\');" title="Xóa">Delete</a>
				</td>';
		}			
	
		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/common/dataTable.php');
		require('includes/views/footer.php');	
	}
	
	public function search() {
	}	
	
	public function create() {
	}		
	
	public function insert() {

	}	
	
	public function edit() {
		$nId = $_GET['id'];
		$pData = $this->getTeamModel()->getTeamById($nId);
		$pLeague = $this->getLeagueModel()->getAllLeague($nId);
		
		if ($pData == null)
			return;
			
		header("Cache-Control: no-cache, must-revalidate");	
		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/' . $this->_szAlias . '/edit.php');
		require('includes/views/footer.php');	
	}	
	
	public function update() {
		header("Cache-Control: no-cache, must-revalidate");
		
		$team_id = $_POST['team_id'];
		$pData = $this->getTeamModel()->getTeamById($team_id);
		$team_name = $_POST['team_name'];
		$league_id = $_POST['league_id'];
		$team_short_name = $_POST['team_short_name'];
		$team_city = $_POST['team_city'];
		$team_stadium = $_POST['team_stadium'];
		$team_fans_num = $_POST['team_fans_num'];
		
		if ($_POST['team_visible'] == "on")
			$team_visible = 1;
		else 
			$team_visible = 0;
		
		$fetch_url = $_POST['fetch_url'];
		if ($fetch_url != ""){
			$szImgData = file_get_contents($fetch_url);		
			file_put_contents("../images/team/" . $team_id . ".png", $szImgData);
		}
		
		$this->getTeamModel()->updateTeam($team_id, $team_name, $team_short_name, $team_city, $team_stadium, "", $team_fans_num, $league_id);			
		header("Location: index.php?nav=" . $this->_szAlias);
		exit;
	}
	
	public function delete()
	{
		header("Cache-Control: no-cache, must-revalidate");
		$nId = $_GET['id'];
		$this->getTeamModel()->deleteTeam($nId);	
		header("Location: index.php?nav=" . $this->_szAlias);
		exit;	
	}	
	
	public function visible()
	{
		header("Cache-Control: no-cache, must-revalidate");
		$story_id = $_GET['visible'];
		//$this->getTeamModel()->visibleStory($story_id);	
		header("Location: index.php?nav=" . $this->_szAlias);
		exit;		
	}
}

?>