<?php 
session_start();

$szModId 	= "funnybet";
$szModPass 	= "fnb@123";

if (!isset($_SESSION['mod_logged'])){
	if ($_POST['un']==$szModId && $_POST['pw'] == $szModPass){
		$_SESSION['mod_logged'] = 1;
	}
	else{
		//header("Location: login.php");
		//exit;
	}
}

require_once('../includes/config.php');
?>