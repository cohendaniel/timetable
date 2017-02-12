<?php
require_once '/../../ChromePhp.php';
//require_once('./includes/database/DB.php');
//local windows access -- use below instead
require_once('/../database/DB_local.php');

if ((isset($_POST['submit-block'])) || (isset($_POST['save-survey']))) {
	ChromePhp::log('pressed button');
	$userID = $_SESSION["userID"];
	$eventID = $_SESSION["eventID"];
	
	$query = "DELETE FROM block WHERE EVENT_ID = $eventID";
	ChromePhp::log($query);
	if($connection->query($query)) {
		ChromePhp::log("Blocks deleted");
	}
	else {
		ChromePhp::log("Blocks not deleted");
	}
	
	for($i=1; $i<=$_POST['num-rows']; $i++) {
		// if block name not filled out for next row, quit. This needs to be more robust,
		// maybe with client side data validation.
		if (empty($_POST['block-name'.$i] )) break;
		
		$date=$_POST['block-year'.$i]."-".$_POST['block-month'.$i]."-".$_POST['block-day'.$i];
		$time="";
		if ($_POST['block-ampm'.$i] == "am" || $_POST['block-hour'.$i] == "12") {
			$time=$_POST['block-hour'.$i].":".$_POST['block-minute'.$i];
			ChromePhp::log($_POST['block-ampm'.$i]."|".$time);
		}
		else {
			$hour = $_POST['block-hour'.$i]+12;
			$time=$hour.":".$_POST['block-minute'.$i];
			ChromePhp::log($_POST['block-ampm'.$i]."|".$time);
		}
		if(save_block($connection, $_POST['block-name'.$i], $date, $time, $_POST['block-slots'.$i], $userID, $eventID)) {
			ChromePhp::log('Submitted! <br/>');
		} 
		else {
			ChromePhp::error('Failed to submit... <br/>');
			return;
		}
	}
	ChromePhp::log('show the URL');
	if (isset($_POST["submit-block"])) {
		header('Location: show-url.php');
	}
	else {
		header('Location: manage.php');
		ChromePhp::log("should redirect to manage");
	}
}
else {
	//ChromePhp::log('SAVE BLOCKS Did not press button');
	return;
}

function save_block($connection, $name, $date, $time, $numSlots, $userID, $eventID) {
	ChromePhp::log($name, $date, $time, $numSlots, $userID, $eventID);
	
	if(!empty($name) && !empty($date) && !empty($time) && !empty($numSlots)) {
		$name = mysqli_real_escape_string($connection, $name);
		$date = mysqli_real_escape_string($connection, $date);
		$time = mysqli_real_escape_string($connection, $time);
		$numSlots = mysqli_real_escape_string($connection, $numSlots);

		$query = "INSERT INTO block VALUES (NULL, '$name', '$date', '$time', '$numSlots', $userID, $eventID)"; 

		if ($run = mysqli_query($connection, $query)) {
			ChromePhp::log("Query to 'block' accepted.<br/>");
			return true;
		} else {
			ChromePhp::error("Query to 'block' not accepted.<br/>");
			return false;
		}
	} else {
		echo ChromePhp::error("Block info not filled out.<br/>");
		return false;
	}
}

?>