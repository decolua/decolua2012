<?php
	$ctx = stream_context_create(array( 
		'http' => array( 
			'timeout' => 0 
			) 
		) 
	); 
	file_get_contents("http://footballchallenger.net/test/createfile.php", 0, $ctx); 
?>