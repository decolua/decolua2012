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
			if ($_GET['info']=="coming")
				$page->getUpComing();				
		}
		if (isset($_GET['action'])){
			if ($_GET['action']=="pay")
				$page->pay();				
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
			if ($_GET['info']=="result")
				$page->getResult();					
		}
	}
	else if ($_GET['nav']=="nation"){
		$page = new NationController();
		$page->start();
	}
	else if ($_GET['nav']=="config"){
		$page = new ConfigController();
		if (isset($_GET['ver'])){
			$page->start();					
		}
	}	
}
?>