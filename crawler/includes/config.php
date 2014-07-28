<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
header('Content-Type: text/html; charset=utf-8');
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$db_host = '23.229.216.198';
$db_user = 'anhvh';
$db_pass = 'challenge';
$db_name = 'funnybet';	
//Web Config

// Configs
require_once('connect.php');
require_once('helpers.php');

//Required Controllers

//Required Models
//require_once('model/TeamModel.php');

//Require Engine
?>