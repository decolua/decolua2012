<?php
	header('Content-Type: text/html; charset=utf-8');
	ini_set('display_errors', 'On');
	include("7m.php");
	include("includes/helpers.php");

	
	$pCrawler = new Crawler();
	//$pCrawler->getMatchInfo(1);
	//$pCrawler->my_explode(",", "17,0,0,0,0,'','','','2014,07,26,14,00,0','1','0.25','0.80','0.90',1");
	$pCrawler->getLiveData(); 
?>