<?php
require_once '/../../ChromePhp.php';
//print_r($_POST);
//require_once('./includes/database/DB.php');
//local windows access -- use below instead
require_once('/../database/DB_local.php');

if (isset($_POST["create-event"])) {
	ChromePhp::log('pressed create event button');
	$userID = mysqli_real_escape_string($connection, $_SESSION["userID"]);
	ChromePhp::log($userID);
	$userEmail = mysqli_real_escape_string($connection, $_SESSION["username"]);
	ChromePhp::log($userEmail);
	$eventName = mysqli_real_escape_string($connection, $_POST["event-name"]);
	// make a unique URL
	$numRows = 0;
	if ($result = $connection->query("SELECT * FROM event WHERE USER_ID = $userID")) {
		$numRows = $result->num_rows;
	}
	$eventURL = sha1($userEmail.$numRows);
	$query = "INSERT INTO event VALUES (NULL, '$eventName', '$userID', '$eventURL')";
	if ($run = mysqli_query($connection, $query)) {
		ChromePhp::log("Query to 'event' accepted.<br/>");
		$_SESSION["eventName"] = $eventName;
		$_SESSION["eventURL"] = $eventURL;
		$query = "SELECT EVENT_ID FROM event WHERE EVENT_URL = '$eventURL'";
		if ($result = $connection->query($query)) {
			$row = $result->fetch_array(MYSQLI_NUM);
			$_SESSION["eventID"] = $row[0];
			header('Location: admin.php');
			return;
		}
		else {
			ChromePhp::error("query for event id not accepted");
		}
	} 
	else {
		ChromePhp::error("Query to 'event' not accepted.<br/>");
		return;
	}
}

?>