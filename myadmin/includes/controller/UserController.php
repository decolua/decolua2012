<?php
class UserController {
	
	private $_szAlias = "user";
	private $_szTitle = "User";
	
	private $_nNumberPerPage = 32;

	private function getUserModel() {
		$getUserModel =  new UserModel();
		return $getUserModel;
	}	

	public function start() {
		$nPage = 0;
		if (isset($_GET['page']))
			$nPage = intval($_GET['page']);
			
		$dataList = $this->getUserModel()->getUserList($nPage, 32);	
		$dataTotal = $this->getUserModel()->countUser();
		$nPageTotal = floor($dataTotal/$this->_nNumberPerPage);
		header("Cache-Control: no-cache, must-revalidate");	
		
		$i = 0;
		$lsTitle[$i++] = '<th class="title"><a href="#">ID</a></th>';
		$lsTitle[$i++] = '<th class="title"><a href="#">Avatar</a></th>';
		$lsTitle[$i++] = '<th class="title"><a href="#">Name</a></th>';
		$lsTitle[$i++] = '<th class="title"><a href="#">Team ID</a></th>';
		$lsTitle[$i++] = '<th class="title"><a href="#">Email</a></th>';
		$lsTitle[$i++] = '<th class="title"><a href="#">Sex</a></th>';
		$lsTitle[$i++] = '<th class="title"><a href="#">Birthday</a></th>';
		$lsTitle[$i++] = '<th class="title"><a href="#">Reg Time</a></th>';
		$lsTitle[$i++] = '<th class="title"><a href="#">Cash</a></th>';
		$lsTitle[$i++] = '<th class="title" width="10"><a href="#">Edit</a></th>';
		$lsTitle[$i++] = '<th class="title" width="10"><a href="#">Del</a></th>';
		
		for ($i=0; $i<count($dataList); $i++){
			$szSex = "male";
			if ($dataList[$i]->user_sex != 0)
				$szSex = "female";
			$j = 0;
			$lsData[$i][$j++] = '<td>' . ($i + 1) . '</td>';
			$lsData[$i][$j++] = '<td align="center"><input id="cb5" name="cid[]" value="5" onclick="" type="checkbox"></td>';		
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->user_id . '</td>';
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->user_avatar . '</td>';
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->user_name . '</td>';
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->team_id . '</td>';
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->user_email . '</td>';
			$lsData[$i][$j++] = '<td>' . $szSex . '</td>';
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->user_birthday . '</td>';
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->user_reg_time . '</td>';
			$lsData[$i][$j++] = '<td>' . $dataList[$i]->user_cash . ' $</td>';
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
		header("Cache-Control: no-cache, must-revalidate");	
		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/' . $this->_szAlias . '/create.php');
		require('includes/views/footer.php');		
	}		
	
	public function edit() {
		$nId = $_GET['id'];
		$pData = $this->getUserModel()->getTeamById($nId);
		header("Cache-Control: no-cache, must-revalidate");	
		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/' . $this->_szAlias . '/edit.php');
		require('includes/views/footer.php');	
	}	
	
	public function insert() {
	}
	
	public function update() {
		header("Cache-Control: no-cache, must-revalidate");
		header("Location: index.php?nav=" . $this->_szAlias);
		exit;
	}
	
	public function delete()
	{
		header("Cache-Control: no-cache, must-revalidate");
		$nId = $_GET['id'];
		$this->getUserModel()->deleteUser($nId);	
		header("Location: index.php?nav=" . $this->_szAlias);
		exit;	
	}	
	
	public function visible()
	{
		header("Cache-Control: no-cache, must-revalidate");
		$story_id = $_GET['visible'];
		//$this->getUserModel()->visibleStory($story_id);	
		header("Location: index.php?nav=" . $this->_szAlias);
		exit;		
	}
}

?>