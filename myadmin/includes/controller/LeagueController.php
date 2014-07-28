<?php
class LeagueController {
	private $_szAlias = "league";
	private $_szTitle = "League";
	private $_nNumberPerPage = 32;
	
	private function getLeagueModel() {
		$getLeagueModel =  new LeagueModel();
		return $getLeagueModel;
	}	
	public function start() {
		$nPage = 0;
		if (isset($_GET['page']))
			$nPage = intval($_GET['page']);
			
		$dataList = $this->getLeagueModel()->getLeagueList($nPage, 32);	
		$dataTotal = $this->getLeagueModel()->countLeague();
		$nPageTotal = floor($dataTotal/$this->_nNumberPerPage);
		header("Cache-Control: no-cache, must-revalidate");	

		$i = 0;
		$lsTitle[$i++] = '<th class="title"><a href="#">Name</a></th>';
		$lsTitle[$i++] = '<th class="title"><a href="#">Short Name</a></th>';
		$lsTitle[$i++] = '<th class="title"><a href="#">Nation</a></th>';
		$lsTitle[$i++] = '<th class="title" width="10"><a href="#">Visible</a></th>';
		$lsTitle[$i++] = '<th class="title" width="10"><a href="#">Edit</a></th>';
		$lsTitle[$i++] = '<th class="title" width="10"><a href="#">Del</a></th>';
		
		for ($i=0; $i<count($dataList); $i++){
			$j = 0;
			$lsData[$i][$j++] = '<td>' . ($i + 1) . '</td>';
			$lsData[$i][$j++] = '<td align="center"><input id="cb5" name="cid[]" value="5" onclick="" type="checkbox"></td>';		
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->league_name . '</td>';
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->league_short_name . '</td>';			
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->nation_id . '</td>';	
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->league_visible . '</td>';			
			$lsData[$i][$j++] = '<td align="center"><a href="index.php?nav=' . $this->_szAlias . '&action=edit&id=' . $dataList[$i]->league_id  . '" title="Sửa">Edit	</a></td>';
			$lsData[$i][$j++] = '
				<td align="center">
					<a href="javascript:void(0);" onclick="confirmDelete(\'index.php?nav=' . $this->_szAlias . '&action=del&id='. $dataList[$i]->league_id  .'\');" title="Xóa">Delete</a>
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
		header("Cache-Control: no-cache, must-revalidate");	
		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/' . $this->_szAlias . '/create.php');
		require('includes/views/footer.php');	
	}		

	public function edit() {
	}	
	
	public function insert() {
		$league_name = $_POST['league_name'];
		$league_short_name = $_POST['league_short_name'];
		$nation_id = $_POST['nation_id'];
		$this->getLeagueModel()->insertLeague($league_name, $league_short_name, $nation_id);		
		header("Location: index.php?nav=" . $this->_szAlias);	
	}
	
	public function update() {
		header("Cache-Control: no-cache, must-revalidate");
		header("Location: index.php?nav=" . $this->_szAlias);
		exit;
	}
	
	public function delete()	{
		header("Cache-Control: no-cache, must-revalidate");
		$nId = $_GET['id'];
		$this->getLeagueModel()->deleteLeague($nId);	
		header("Location: index.php?nav=" . $this->_szAlias);
		exit;	
	}
	
	
	public function visible()	{
		header("Cache-Control: no-cache, must-revalidate");
		$nId = $_GET['id'];
		$this->getLeagueModel()->visibleLeague($nId);	
		header("Location: index.php?nav=" . $this->_szAlias);
		exit;		
	}
}

?>