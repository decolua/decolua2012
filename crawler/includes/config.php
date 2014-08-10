<?php
ob_start();
//error_reporting(E_ALL);
error_reporting(0);
ini_set('display_errors', 'Off');
header('Content-Type: text/html; charset=utf-8');
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Configs
require_once('connect.php');
require_once('helpers.php');

//Required Controllers

//Required Models
require_once('model/TeamModel.php');
require_once('model/7mModel.php');
require_once('model/MatchModel.php');
require_once('model/UserModel.php');


//Require Engine
?>