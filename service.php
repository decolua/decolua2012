<?php 
session_start();

require_once('includes/config.php');

if (isset($_GET['nav']))
{
	if ($_GET['nav']=="team"){
		$page = new TeamController();
		if (isset($_GET['info'])){
			if ($_GET['info']=="all")
				$page->getAll();
		}	
	}
	else if ($_GET['nav']=="league"){
		$page = new LeagueController();
		if (isset($_GET['info'])){
			if ($_GET['info']=="all")
				$page->getAll();
		}
	}
	else if ($_GET['nav']=="match"){
		$page = new MatchController();
		if (isset($_GET['info'])){
			if ($_GET['info']=="live")
				$page->getLiving();
			else if ($_GET['info']=="coming")
				$page->getUpComing();
			else if ($_GET['info']=="byids")
				$page->getMatchListByIds();
			if ($_GET['info']=="test")
				$page->getTest();				
		}
		if (isset($_GET['action'])){
			if ($_GET['action']=="pay")
				$page->pay();		
			else if ($_GET['action']=="return")
				$page->ret();				
		}		
	}
	else if ($_GET['nav']=="user"){
		$page = new UserController();
		if (isset($_GET['action'])){
			if ($_GET['action']=="login")
				$page->login();
			else if ($_GET['action']=="register")
				$page->register();		
			else if ($_GET['action']=="pass")
				$page->getpass();					
		}
	}
	else if ($_GET['nav']=="betting"){
		$page = new BettingController();
		if (isset($_GET['action'])){
			if ($_GET['action']=="bet")
				$page->bet();					
		}
		else if (isset($_GET['info'])){
			if ($_GET['info']=="bet")
				$page->bet();
			else if ($_GET['info']=="result")
				$page->getResult();	
			else if ($_GET['info']=="user")
				$page->byUser();					
		}
	}
	else if ($_GET['nav']=="odds"){
		$page = new OddsController();
		if (isset($_GET['info'])){
			if ($_GET['info']=="count")
				$page->countOdds();					
		}
	}	
	else if ($_GET['nav']=="nation"){
		$page = new NationController();
		$page->start();
	}
	else if ($_GET['nav']=="config"){
		$page = new ConfigController();
		$page->start();
	}	
	else if ($_GET['nav']=="logout"){
		$page = new ServerController();
		if (isset($_GET['info'])){
			if ($_GET['info']=="curtime")
				$page->getCurTime();
		}
	}
	else if ($_GET['nav']=="server"){
		$page = new ServerController();
		if (isset($_GET['info'])){
			if ($_GET['info']=="curtime")
				$page->getCurTimeStr();
		}
	}	
}
?>