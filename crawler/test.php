<?php
	header('Content-Type: text/html; charset=utf-8');
	ini_set('display_errors', 'On');
	include("7m.php");
	include("includes/helpers.php");

	$pCrawler = new Crawler();
	var_dump($pCrawler->getLiveData()); 
?>