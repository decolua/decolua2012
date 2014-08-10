<?php
//$fp = fsockopen('ssphim.com', 8080, $errno, $errstr, 5);
//$fp = fsockopen('127.0.0.1', 466, $errno, $errstr, 5);
$fp = fsockopen('74.125.129.108', 80, $errno, $errstr, 5);

if (!$fp) {
    // port is closed or blocked
	echo $errstr;
} else {
    // port is open and available
	echo "2";
    fclose($fp);
}
?> 