<?php
	echo 123;
	echo "EfTts*;by6cz";
	return;
	header('Content-Type: text/html; charset=utf-8');
	ini_set('display_errors', 'On');
	include("crawler.php");
	include("includes/helpers.php");

	$pCrawler = new Crawler();
	$pCrawler->getSkyBetSoccerInfo("");
?>