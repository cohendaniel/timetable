<?php
session_start();
require_once '/../../ChromePhp.php';
//require_once('./includes/database/DB.php');
//local windows access -- use below instead
require_once('/../database/DB_local.php');

if (isset($_POST)) {
	ChromePhp::log('entered edit_event function');
	ChromePhp::log($_POST);
	$editRow = $_POST['editRow'];
	$userID = $_SESSION['userID'];
	
	$result = $connection->query("SELECT EVENT_ID, EVENT_NAME, EVENT_URL FROM event WHERE USER_ID = $userID");
	mysqli_data_seek($result, $editRow);
	$eventInfo = $result->fetch_array(MYSQLI_NUM);
	$eventID = $eventInfo[0];
	$eventName = $eventInfo[1];
	$eventURL = $eventInfo[2];
	$_SESSION["eventName"] = $eventName;
	$_SESSION["eventID"] = $eventID;
	$_SESSION["eventURL"] = $eventURL;
	
	$query = "SELECT BLOCK_NAME, BLOCK_DATE, BLOCK_TIME, BLOCK_NUM_SLOTS FROM block WHERE EVENT_ID = $eventID"; 

	if ($data = mysqli_query($connection, $query)) {
		ChromePhp::log("Query accepted.");
		$rows=[];
		while ($row=mysqli_fetch_assoc($data)) {
			$rows[]=$row;
		}
		$rows[]=$eventName;
		echo json_encode($rows);
	} 
	else {
		ChromePhp::error("Query not accepted.<br/>");
		return NULL;
	}
}

?>