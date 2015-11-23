<?php
require_once '/../../ChromePhp.php';
//print_r($_POST);
//require_once('./includes/database/DB.php');
//local windows access -- use below instead
require_once('/../database/DB_local.php');

if (isset($_POST["submit-block"])) {;
	ChromePhp::log('pressed button');
	for($i=1; $i<((count($_POST)-1)/4)+1; $i++) {
		if(save_block($connection, $_POST['block-name'.$i], $_POST['block-date'.$i], $_POST['block-time'.$i], $_POST['block-slots'.$i])) {
			ChromePhp::log('Submitted! <br/>');
		} 
		else {
			ChromePhp::error('Failed to submit... <br/>');
		}
	}
}
else {
	ChromePhp::log('did not press button');
}

function save_block($connection, $name, $date, $time, $numSlots) {
	ChromePhp::log($name, $date, $time, $numSlots);
	
	if(!empty($name) && !empty($date) && !empty($time) && !empty($numSlots)) {
		$name = mysqli_real_escape_string($connection, $name);
		$date = mysqli_real_escape_string($connection, $date);
		$time = mysqli_real_escape_string($connection, $time);
		$numSlots = mysqli_real_escape_string($connection, $numSlots);

		$query = "INSERT INTO block VALUES (NULL, '$name', '$date', '$time', '$numSlots')"; 

		if ($run = mysqli_query($connection, $query)) {
			ChromePhp::log("Query accepted.<br/>");
			return true;
		} else {
			ChromePhp::error("Query not accepted.<br/>");
			return false;
		}
	} else {
		echo ChromePhp::error("Something not filled out.<br/>");
		return false;
	}
}

?>