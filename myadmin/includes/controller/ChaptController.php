<?php
//Menu home controller
class ChaptController {

	private function getStoryModel() {
		$getStoryModel =  new StoryModel();
		return $getStoryModel;
	}
	
	private function getCategoryModel() {
		$getCategoryModel =  new CategoryModel();
		return $getCategoryModel;
	}	
	
	private function getChaptModel() {
		$getChaptModel =  new ChaptModel();
		return $getChaptModel;
	}		

	public function start() {

		$nPage = 0;
		if (isset($_GET['page']))
			$nPage = intval($_GET['page']);
			
		$nStoryId = 0;
		if (isset($_GET['chapt']))
			$nStoryId = intval($_GET['chapt']);			
			
		$storyData = $this->getStoryModel()->getStory($nStoryId);
			
		$chaptList = $this->getChaptModel()->getChaptByStoryId($nStoryId, $nPage, 32);	
		
		$nChaptTotal = $this->getChaptModel()->countChaptByStoryId($nStoryId);
		$nPageTotal = floor($nChaptTotal/32);
		header("Cache-Control: no-cache, must-revalidate");	
	
		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/common/chaptList.php');
		require('includes/views/footer.php');
	}
	
	public function create() {
		$nStoryId = 0;
		if (isset($_GET['chapt']))
			$nStoryId = intval($_GET['chapt']);	
		
		$storyData = $this->getStoryModel()->getStory($nStoryId);
		
		$nPage = 0;
		$nPageTotal = 0;
		$chaptList = $this->getChaptModel()->getChaptByStoryId($nStoryId, $nPage, 5);
		$nChaptCount = $this->getChaptModel()->countChaptByStoryId($nStoryId);	
			
		header("Cache-Control: no-cache, must-revalidate");	
		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/chapt/create.php');
		require('includes/views/footer.php');
	}		
	
	public function edit() {
		$nStoryId = 0;
		if (isset($_GET['chapt']))
			$nStoryId = intval($_GET['chapt']);	
		
		$storyData = $this->getStoryModel()->getStory($nStoryId);	
	
		$nChaptId = intval($_GET['edit']);
		$chaptData = $this->getChaptModel()->getChaptById($nChaptId);

		//$chaptData[0]->chapt_content = preg_replace('/(<p\><\/p\>)/', '\n', $chaptData[0]->chapt_content);
		
		header("Cache-Control: no-cache, must-revalidate");	
		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/chapt/edit.php');
		require('includes/views/footer.php');
	}	
	
	public function auto()
	{
		$nStoryId = 0;
		if (isset($_GET['chapt']))
			$nStoryId = intval($_GET['chapt']);	
		
		$storyData = $this->getStoryModel()->getStory($nStoryId);	
		
		$nPage = 0;
		$nPageTotal = 0;
		$chaptList = $this->getChaptModel()->getChaptByStoryId($nStoryId, $nPage, 5);	
		$nChaptCount = $this->getChaptModel()->countChaptByStoryId($nStoryId);			
		
		header("Cache-Control: no-cache, must-revalidate");	
		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/chapt/auto.php');
		require('includes/views/footer.php');		
	}
	
	public function wattpad()
	{
		$nStoryId = 0;
		if (isset($_GET['chapt']))
			$nStoryId = intval($_GET['chapt']);	
		
		$storyData = $this->getStoryModel()->getStory($nStoryId);	
		
		$nPage = 0;
		$nPageTotal = 0;
		$chaptList = $this->getChaptModel()->getChaptByStoryId($nStoryId, $nPage, 5);	
		$nChaptCount = $this->getChaptModel()->countChaptByStoryId($nStoryId);			
		
		header("Cache-Control: no-cache, must-revalidate");	
		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/chapt/auto.php');
		require('includes/views/footer.php');		
	}	
	
	public function insert() {
		header("Cache-Control: no-cache, must-revalidate");
		$story_id = $_POST['story_id'];
		$chapt_title = $_POST['chapt_title'];
		$chapt_content = $_POST['chapt_content'];
		
		$chapt_content = preg_replace('/(\r)/', '', $chapt_content);
		$chapt_content = preg_replace('/(\n)/', '<p></p>', $chapt_content);
		$nLastChaptId = $this->getChaptModel()->InsertChapt($story_id, $chapt_title, $chapt_content);
		$nChaptTotal = $this->getChaptModel()->countChaptByStoryId($story_id);
		$this->getStoryModel()->UpdateChaptInfo($story_id, $nChaptTotal , $nLastChaptId, $chapt_title);
		
		header("Location: index.php?chapt=" . $story_id . "&create=1");
		exit;
	}
	
	public function update() {
		header("Cache-Control: no-cache, must-revalidate");
		$story_id = $_POST['story_id'];
		$chapt_id = $_POST['chapt_id'];
		$chapt_title = $_POST['chapt_title'];
		$chapt_content = $_POST['chapt_content'];

		$chapt_content = preg_replace('/(\r)/', '', $chapt_content);
		$chapt_content = preg_replace('/(\n)/', '<p></p>', $chapt_content);		
		$this->getChaptModel()->UpdateChapt($story_id, $chapt_id, $chapt_title, $chapt_content);
		$nChaptTotal = $this->getChaptModel()->countChaptByStoryId($story_id);
		$this->getStoryModel()->UpdateStoryChaptTotal($story_id, $nChaptTotal);
		
		header("Location: index.php?chapt=" . $story_id);
		exit;
	}	
	
	public function delete()
	{
		$story_id = $_GET['chapt'];
		$chapt_id = $_GET['del'];

		$this->getChaptModel()->deleteChapt($story_id, $chapt_id);
		
		header("Location: index.php?chapt=" . $story_id);
		exit;		
	}
	
	public function deleteup()
	{
		$story_id = $_GET['chapt'];
		$chapt_id = $_GET['delup'];

		$this->getChaptModel()->deleteUpChapt($story_id, $chapt_id);
		
		header("Location: index.php?chapt=" . $story_id);
		exit;		
	}
}

?>