<?php
	error_log('Including database.<br/>');
	$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

	$db_host = $url["host"];
	$db_user = $url["user"];
	$db_password = $url["pass"];
	$db = substr($url["path"], 1);
	
	$db_name = 'guides';
	
	if($connection = mysqli_connect($db_host, $db_user, $db_password, $db)) {
		
		error_log('Connected to the database server. <br/>');
		
		if($database = mysqli_select_db($connection, $db)) {
			error_log('Database has been selected. <br/>');
		} else {
			error_log('Database was not found. <br/>');
		}
	} else {
		error_log('Unable to connect to MySql server. <br/>');
	}
?>