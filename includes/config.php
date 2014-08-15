<?php
ob_start();
//error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL);
ini_set('display_errors', 'On');
header('Content-Type: text/html; charset=utf-8');
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//header("Vary: Accept-Encoding");
//date_default_timezone_set('Asia/Bangkok');

define("SERVERUTC", "-12:00");

// Configs
require_once('connect.php');
require_once('helpers.php');
require_once('class.phpmailer.php');

//Required Controllers
require_once('controller/LeagueController.php');
require_once('controller/TeamController.php');
require_once('controller/MatchController.php');
require_once('controller/UserController.php');
require_once('controller/BettingController.php');
require_once('controller/ConfigController.php');
require_once('controller/ServerController.php');
require_once('controller/OddsController.php');

//Required Models,
require_once('model/LeagueModel.php');
require_once('model/TeamModel.php');
require_once('model/MatchModel.php');
require_once('model/UserModel.php');
require_once('model/BettingModel.php');
require_once('model/ConfigModel.php');
require_once('model/OddsModel.php');

//Require Engine

?>