<?php		
	include("7m.php");		
	include("includes/config.php");		
	$pCrawler = new Crawler();	
	$pCrawler->_bUseProxy = true;
	$pMatchData = $pCrawler->getMatchInfo(1);
?>