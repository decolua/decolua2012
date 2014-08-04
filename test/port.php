<?php
$url = "http://ssphim.com/ssweb3/images/images/logo.png";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, True);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);
curl_setopt($ch, CURLOPT_PORT, 8080);
$report=curl_getinfo($ch);
print_r($report);
$result = curl_exec($ch);
curl_close($ch);
echo $result;
return;

//$url = 'https://gateway.sandbox.push.apple.com:2195';
$fp = fsockopen('ssphim.com', 8080, $errno, $errstr, 5);
//$fp = fsockopen('127.0.0.1', 80, $errno, $errstr, 5);
if (!$fp) {
    // port is closed or blocked
	echo $errstr;
} else {
    // port is open and available
	echo "2";
    fclose($fp);
}
?>