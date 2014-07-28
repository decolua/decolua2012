<?php 
session_start();

$szModId 	= "camapblue";
$szModPass 	= "bluecamap@123";

if (!isset($_SESSION['logged'])){
	if ($_POST['un']==$szModId && $_POST['pw'] == $szModPass){
		$_SESSION['logged'] = 1;
	}
	else{
		header("Location: login.php");
		exit;
	}
}

require_once('includes/config.php');

if (isset($_GET['nav']))
{
	if ($_GET['nav']=="team"){
		$page = new TeamController();
		if (isset($_GET['action'])){
			if ($_GET['action']=="edit")
				$page->edit();
			else if ($_GET['action']=="del")
				$page->delete();
			else if ($_GET['action']=="create")
				$page->create();
			else if ($_GET['action']=="visible")
				$page->visible();	
			else if ($_GET['action']=="update")
				$page->update();				
		}
		else{
			$page->start();
		}
	}
	else if ($_GET['nav']=="league"){
		$page = new LeagueController();
		if (isset($_GET['action'])){
			if ($_GET['action']=="edit")
				$page->edit();
			else if ($_GET['action']=="del")
				$page->delete();
			else if ($_GET['action']=="create")
				$page->create();
			else if ($_GET['action']=="visible")
				$page->visible();
			else if ($_GET['action']=="insert")
				$page->insert();					
		}
		else{
			$page->start();
		}
	}
	else if ($_GET['nav']=="user"){
		$page = new UserController();
		if (isset($_GET['action'])){
			if ($_GET['action']=="edit")
				$page->edit();
			else if ($_GET['action']=="del")
				$page->delete();
			else if ($_GET['action']=="create")
				$page->create();
			else if ($_GET['action']=="visible")
				$page->visible();
			else if ($_GET['action']=="insert")
				$page->insert();	
			else if ($_GET['action']=="update")
				$page->update();					
		}
		else{
			$page->start();
		}
	}
	else if ($_GET['nav']=="nation"){
		$page = new NationController();
		$page->start();
	}
}
else
{
	$page = new HomeController();
	$page->start();
}
?>