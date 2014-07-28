<?php
//Menu home controller
class StoryController {

	private function getStoryModel() {
		$getStoryModel =  new StoryModel();
		return $getStoryModel;
	}
	
	private function getCategoryModel() {
		$getCategoryModel =  new CategoryModel();
		return $getCategoryModel;
	}	
	
	private function getTagModel() {
		$getTagModel =  new TagModel();
		return $getTagModel;
	}		

	private function resizeIMG($file, $h, $w) {
		require_once('includes/SimpleImage.php');
		$img = new SimpleImage();
		$img->load($file);
		$img->resize($h, $w);
		$img->save($file);
	}	

	private function scaleImg($filename, $w, $h)
	{
		// Get new dimensions
		list($width, $height) = getimagesize($filename);
		$new_width = $w;
		$new_height = $h;

		// Resample
		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromjpeg($filename);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		// Output
		imagejpeg($image_p, $filename, 96);	
	}
	
	public function start() {
		$nPage = 0;
		if (isset($_GET['page']))
			$nPage = intval($_GET['page']);
			
		$storyList = $this->getStoryModel()->getStoryByCategory(0, $nPage, 32);	
		$nStoryTotal = $this->getStoryModel()->countStory();
		$nPageTotal = floor($nStoryTotal/32);
		header("Cache-Control: no-cache, must-revalidate");	
	
		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/common/storyList.php');
		require('includes/views/footer.php');
	}
	
	public function search() {
		header("Cache-Control: no-cache, must-revalidate");
	
		$nPage = 0;
		if (isset($_GET['page']))
			$nPage = intval($_GET['page']);
			
		$szKeyWord = "";
		if (isset($_GET['search']))
			$szKeyWord = trim($_GET['search']);
			
		$szKeyWord = str_replace( "D", '_', $szKeyWord);
		$szKeyWord = str_replace( "d", '_', $szKeyWord);
	
		$storyList = $this->getStoryModel()->searchStory($szKeyWord, "", 0, 0, $nPage, 32);	
		$nStoryTotal = $this->getStoryModel()->countSearch($szKeyWord, "", 0);
		$nPageTotal = floor($nStoryTotal/32);

		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/common/storyList.php');
		require('includes/views/footer.php');
	}	
	
	public function create() {
	
		$rs = $this->getCategoryModel()->getCategoryList();
		header("Cache-Control: no-cache, must-revalidate");	
		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/story/create.php');
		require('includes/views/footer.php');
	}		
	
	public function edit() {
		$nStoryId = intval($_GET['edit']);
		$storyData = $this->getStoryModel()->getStory($nStoryId);	
		$rs = $this->getCategoryModel()->getCategoryList();
		header("Cache-Control: no-cache, must-revalidate");	
		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/story/edit.php');
		require('includes/views/footer.php');
	}	
	
	public function insert() {

		header("Cache-Control: no-cache, must-revalidate");
		
		$story_type = 0;
		if (isset($_POST['story_type']))
			$story_type = 1;		
		
		if ($_POST['leech_link'] == ""){
			$story_title = $_POST['story_title'];
			$story_desc = $_POST['story_desc'];
			$story_desc = preg_replace('/(\r)/', '', $story_desc);
			$story_desc = preg_replace('/(\n)/', '<p></p>', $story_desc);
			$story_image = "";
			$story_status = $_POST['story_status'];
			$story_cat_name = $_POST['story_cat_name'];
			$story_cat_alias = $_POST['story_cat_alias'];
			$story_author_name = $_POST['story_author_name'];
			$story_clip = "";

			if ($_FILES["file"] != null)
			{
				$szFileName = convertImgName($story_title);
				$story_image = $szFileName . ".jpg";
				if (uploadImage("file", "../images/story/", $szFileName . ".jpg")){
					$this->scaleImg("../images/story/" . $szFileName . ".jpg", 160, 210);
					copy("../images/story/" . $szFileName . ".jpg", "../images/thumbstory/" . $szFileName . ".jpg");
					$this->scaleImg("../images/thumbstory/" . $szFileName . ".jpg", 55, 72);	
					copy("../images/story/" . $szFileName . ".jpg", "../images/storylist/" . $szFileName . ".jpg");
					$this->scaleImg("../images/storylist/" . $szFileName . ".jpg", 85, 120);					
					textOverImage("../images/story/" . $szFileName . ".jpg", "http://sstruyen.com");
					$story_image = $szFileName . ".jpg";
				}		
			}		
		}
		else{
			$pStoryInfoEngine = new StoryInfoEngine();
			$pStoryInfoEngine->GetStoryInfo($_POST['leech_link']);	
			$story_title = trim($pStoryInfoEngine->_szTitle);
			$szFileName = convertImgName($story_title);
			$story_image = $szFileName . ".jpg";			
			$story_desc = trim($pStoryInfoEngine->_szDesc);
			$story_status = "";
			$story_cat_name = $_POST['story_cat_name'];
			$story_cat_alias = $_POST['story_cat_alias'];
			$story_author_name = trim($pStoryInfoEngine->_szAuthor);
			if ($pStoryInfoEngine->_szImg != ""){
				$szData = file_get_contents($pStoryInfoEngine->_szImg);
				if ($szData !== FALSE){
					file_put_contents("../images/story/" . $szFileName . ".jpg", $szData);
					$this->scaleImg("../images/story/" . $szFileName . ".jpg", 160, 210);
					copy("../images/story/" . $szFileName . ".jpg", "../images/thumbstory/" . $szFileName . ".jpg");
					$this->scaleImg("../images/thumbstory/" . $szFileName . ".jpg", 55, 72);	
					copy("../images/story/" . $szFileName . ".jpg", "../images/storylist/" . $szFileName . ".jpg");
					$this->scaleImg("../images/storylist/" . $szFileName . ".jpg", 85, 120);					
					textOverImage("../images/story/" . $szFileName . ".jpg", "http://sstruyen.com");
					$story_image = $szFileName . ".jpg";
				}				
			}
			
			$story_status = $_POST['story_status'];
		}

		$szStory = $this->getStoryModel()->InsertStory($story_title, $story_desc, $story_image, $story_status, $story_cat_name, $story_cat_alias, $story_author_name, $story_clip, $story_type);			
		
		// Update SiteMap
		$ctx = stream_context_create(array( 
				'http' => array( 
					'timeout' => 1 
				) 
			) 
		); 
		file_get_contents("http://sstruyen.com/schedule/_sitemap.php", 0, $ctx); 
		file_get_contents("http://sstruyen.com/ssadm/autoforum/zing-blog.php?id=" . $szStory, 0, $ctx); 
		file_get_contents("http://sstruyen.com/ssadm/autoforum/zing-blog-en.php?id=" . $szStory, 0, $ctx); 
		
		header("Location: index.php?a=story");
		exit;
	}
	
	public function update() {
		header("Cache-Control: no-cache, must-revalidate");
		$story_id = $_POST['story_id'];
		$story_title = $_POST['story_title'];
		$story_desc = $_POST['story_desc'];
		$story_desc = preg_replace('/(\r)/', '', $story_desc);
		$story_desc = preg_replace('/(\n)/', '<p></p>', $story_desc);
		$story_image = $_POST['story_image'];;
		$story_status = $_POST['story_status'];
		$story_cat_name = $_POST['story_cat_name'];
		$story_cat_alias = $_POST['story_cat_alias'];
		$story_author_name = $_POST['story_author_name'];
		$story_clip	= $_POST['story_clip'];
		$story_type = 0;
		if (isset($_POST['story_type']))
			$story_type = 1;
		$story_tags	= $_POST['story_tags'];

		if ($_FILES["file"] != null){
			$szFileName = convertImgName($story_title);
			$story_image = $szFileName . ".jpg";
			if (uploadImage("file", "../images/story/", $szFileName . ".jpg"))
			{
				$this->scaleImg("../images/story/" . $szFileName . ".jpg", 160, 210);
				unlink("../images/thumbstory/" . $szFileName . ".jpg");
				copy("../images/story/" . $szFileName . ".jpg", "../images/thumbstory/" . $szFileName . ".jpg");
				$this->scaleImg("../images/thumbstory/" . $szFileName . ".jpg", 55, 72);
				unlink("../images/storylist/" . $szFileName . ".jpg");
				copy("../images/story/" . $szFileName . ".jpg", "../images/storylist/" . $szFileName . ".jpg");
				$this->scaleImg("../images/storylist/" . $szFileName . ".jpg", 85, 120);				
				$story_image = $szFileName . ".jpg";
				textOverImage("../images/story/" . $szFileName . ".jpg", "http://sstruyen.com");
			}	
		}	
		
		$this->getTagModel()->insertTags($story_tags);
		$this->getStoryModel()->UpdateStory($story_id, $story_title, $story_desc, $story_image, $story_status, $story_cat_name, $story_cat_alias, $story_author_name, $story_clip, $story_type, $story_tags);			
		
		header("Location: index.php?a=story");
		exit;
	}
	
	public function delete()
	{
		header("Cache-Control: no-cache, must-revalidate");
		$story_id = $_GET['del'];
		$this->getStoryModel()->deleteStory($story_id);	
		header("Location: index.php?a=story");
		exit;	
	}
	
	public function deletechapt()
	{
		header("Cache-Control: no-cache, must-revalidate");
		$story_id = $_GET['delchapt'];
		$this->getStoryModel()->deleteChaptByStory($story_id);	
		header("Location: index.php?a=story");
		exit;	
	}	
	
	public function top()
	{
		header("Cache-Control: no-cache, must-revalidate");
		$story_id = $_GET['top'];
		$up = true;
		if ($_GET['down'])
			$up = false;
		$this->getStoryModel()->upTop($story_id, $up);	
		header("Location: index.php?a=story");
		exit;	
	}	

	public function hot()
	{
		header("Cache-Control: no-cache, must-revalidate");
		$story_id = $_GET['hot'];
		$this->getStoryModel()->setHot($story_id);	
		header("Location: index.php?a=story");
		exit;	
	}
	
	public function visible()
	{
		header("Cache-Control: no-cache, must-revalidate");
		$story_id = $_GET['visible'];
		$this->getStoryModel()->visibleStory($story_id);	
		header("Location: index.php?a=story");
		exit;		
	}
	
	public function ads()
	{
		header("Cache-Control: no-cache, must-revalidate");
		$story_id = $_GET['ads'];
		$this->getStoryModel()->adsStory($story_id);	
		header("Location: index.php?a=story");
		exit;		
	}	

}

?>