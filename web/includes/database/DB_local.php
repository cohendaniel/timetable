<?php
	//echo 'Including database.<br/>';
	//$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

	$db_host = 'localhost';
	$db_user = 'root';
	$db_password = '';
	$db = 'timetable';
	
	$db_name = 'timetable';
	
	if($connection = mysqli_connect($db_host, $db_user, $db_password, $db)) {
		
		//echo 'Connected to the database server. <br/>';
		
		if($database = mysqli_select_db($connection, $db)) {
			//echo 'Database has been selected. <br/>';
		} else {
			//echo 'Database was not found. <br/>';
		}
	} else {
		//echo 'Unable to connect to MySql server. <br/>';
	}
?>