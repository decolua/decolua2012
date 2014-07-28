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
	}
	else if ($_GET['nav']=="league"){
		$page = new LeagueController();
		if (isset($_GET['info'])){
			if ($_GET['info']=="all")
				$page->getAll();
			else if ($_GET['info']=="del")
				$page->delete();					
		}
	}
	else if ($_GET['nav']=="user"){
		$page = new UserController();
		$page->start();
	}
	else if ($_GET['nav']=="nation"){
		$page = new NationController();
		$page->start();
	}
}
?>