<?php		
	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

	$time_start = microtime_float();
	file_get_contents("http://onlineproxyfree.com/index.php?q=aHR0cDovL2N0Yy43bS5jbi9kYXRhZmlsZS9mZW4uanM%2FdD0xMjMxMjMxMg==");	
	$time_end = microtime_float();
	$time = $time_end - $time_start;
	echo "<br/> Time $time seconds\n";
	
	$time_start = microtime_float();
	file_get_contents("http://www.zfreez.com/index.php?q=aHR0cDovL2N0Yy43bS5jbi9kYXRhZmlsZS9mZW4uanM%2FdD0xMjMxMjMxMg==");	
	$time_end = microtime_float();
	$time = $time_end - $time_start;
	echo "<br/> Time $time seconds\n";

	$time_start = microtime_float();
	file_get_contents("http://rxproxy.com/index.php?rxproxyuri=aHR0cDovL2N0Yy43bS5jbi9kYXRhZmlsZS9mZW4uanM%2FdD0xMjMxMjMxMg==");	
	$time_end = microtime_float();
	$time = $time_end - $time_start;
	echo "<br/> Time $time seconds\n";	
	
	$time_start = microtime_float();
	file_get_contents("http://sstruyen.com/skybet/proxy.php?url=http://ctc.7m.cn/datafile/fen.js?t=12312312");	
	$time_end = microtime_float();
	$time = $time_end - $time_start;
	echo "<br/> Time $time seconds\n";		
?>