<?php 
	$szData = date('Y-m-d h:i:s'); 
	file_put_contents("two.txt", $szData . chr(13) . chr(10), FILE_APPEND);
?>