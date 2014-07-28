<?php
//Menu home controller
class AutoController {

	private function getAutoModel() {
		$getAutoModel =  new AutoModel();
		return $getAutoModel;
	}

	public function start() {
		$nOrder = 0;
		if (isset($_GET["order"]))
			$nOrder = intval($_GET["order"]);
		
		$lsAuto = $this->getAutoModel()->getAllAuto($nOrder);
		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/auto/auto.php');
		require('includes/views/footer.php');
	}
	
	public function stop()
	{
		header("Cache-Control: no-cache, must-revalidate");	
		$nAutoId = intval($_GET['stop']);
		$this->getAutoModel()->stopAutoById($nAutoId);
		header("location: http://sstruyen.com/ssadm/index.php?a=auto");
	}	
	
	public function reset()
	{
		header("Cache-Control: no-cache, must-revalidate");	
		$nAutoId = intval($_GET['reset']);
		$this->getAutoModel()->resetAutoById($nAutoId);
		header("location: http://sstruyen.com/ssadm/index.php?a=auto");
	}		
	
	public function delete()
	{
		header("Cache-Control: no-cache, must-revalidate");	
		$nAutoId = intval($_GET['del']);
		$this->getAutoModel()->delAutoById($nAutoId);
		header("location: http://sstruyen.com/ssadm/index.php?a=auto");
	}
}

?>