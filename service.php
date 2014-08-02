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
		}
	}
	else if ($_GET['nav']=="user"){
		$page = new UserController();
		if (isset($_GET['action'])){
			if ($_GET['ac']=="login")
				$page->login();
			if ($_GET['ac']=="register")
				$page->register();		
			if ($_GET['ac']=="pass")
				$page->getpass();					
		}
	}
	else if ($_GET['nav']=="nation"){
		$page = new NationController();
		$page->start();
	}
}
?>