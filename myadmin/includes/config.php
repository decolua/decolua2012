<?php
ob_start();
//error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL);
ini_set('display_errors', 'On');
header('Content-Type: text/html; charset=utf-8');
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Vary: Accept-Encoding");

//DB
/*
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'baoanh1';
$db_name = 'ztruyen';	
*/
$db_host = '23.229.216.198';
$db_user = 'anhvh';
$db_pass = 'challenge';
$db_name = 'funnybet';	
//Web Config

// Configs
require_once('connect.php');
require_once('helpers.php');

//Required Controllers
require_once('controller/HomeController.php');
require_once('controller/TeamController.php');
require_once('controller/LeagueController.php');
require_once('controller/UserController.php');

//Required Models
require_once('model/TeamModel.php');
require_once('model/BettingModel.php');
require_once('model/LeagueModel.php');
require_once('model/MatchModel.php');
require_once('model/NationModel.php');
require_once('model/OddsModel.php');
require_once('model/UserModel.php');


//Require Engine

?>