<?php
//Menu home controller
class HomeController {
	public function start() {
		require('includes/views/header.php');
		require('includes/views/menu.php'); 
		require('includes/views/home/home.php');
		require('includes/views/footer.php');
	}
}

?>