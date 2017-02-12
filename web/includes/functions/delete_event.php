<?php
session_start();
require_once '/../../ChromePhp.php';
//require_once('./includes/database/DB.php');
//local windows access -- use below instead
require_once('/../database/DB_local.php');

if (isset($_POST)) {
	ChromePhp::log('entered delete_event function');
	$eventRow = $_POST['eventRow'];
	$userID = $_SESSION['userID'];
	
	$result = $connection->query("SELECT EVENT_ID, EVENT_NAME FROM event WHERE USER_ID = $userID");
	mysqli_data_seek($result, $eventRow);
	$eventInfo = $result->fetch_array(MYSQLI_NUM);
	$eventID = $eventInfo[0];
	
	$query = "DELETE FROM event WHERE EVENT_ID = $eventID"; 

	if ($data = mysqli_query($connection, $query)) {
		ChromePhp::log("Delete accepted.");
		header("Refresh:0");
		return true;
	} 
	else {
		ChromePhp::error("Delete not accepted.<br/>");
		return NULL;
	}
}

?>