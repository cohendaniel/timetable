<?php
session_start();
require_once '/../../ChromePhp.php';
//require_once('./includes/database/DB.php');
//local windows access -- use below instead
require_once('/../database/DB_local.php');

if (isset($_POST)) {
	ChromePhp::log('entered get_events function');
	$userID = $_SESSION["userID"];
	$query = "SELECT EVENT_ID, EVENT_NAME, EVENT_URL FROM event WHERE USER_ID = $userID"; 
	ChromePhp::log($query);
	if ($data = mysqli_query($connection, $query)) {
		ChromePhp::log("Query accepted.");
		while ($row=mysqli_fetch_assoc($data)) {
			$eventID = $row["EVENT_ID"];
			$query = "SELECT * FROM item WHERE EVENT_ID = $eventID";
			if ($result = mysqli_query($connection, $query)) {
				$num_rows = $result->num_rows;
				ChromePhp::log($num_rows);
			}
			$row["NUM_ROWS"]=$num_rows;
			$rows[]=$row;
		}
		echo json_encode($rows);
	} 
	else {
		ChromePhp::error("Query not accepted.<br/>");
		return NULL;
	}
}
else {
	ChromePhp::log("not set");
}

?>