<?php
session_start();
require_once '/../../ChromePhp.php';
//require_once('./includes/database/DB.php');
//local windows access -- use below instead
require_once('/../database/DB_local.php');

if (isset($_POST)) {
	ChromePhp::log('entered get_items function');
	$userID = $_SESSION["userID"];
	$eventRow = $_POST['eventRow'];
	
	$result = $connection->query("SELECT EVENT_ID FROM event WHERE USER_ID = $userID");
	mysqli_data_seek($result, $eventRow);
	$eventInfo = $result->fetch_array(MYSQLI_NUM);
	$eventID = $eventInfo[0];
	
	$_SESSION["eventID"] = $eventID;
	
	$query = "SELECT ITEM_ID, ITEM_NAME FROM item WHERE EVENT_ID = $eventID"; 
	ChromePhp::log($query);
	if ($data = mysqli_query($connection, $query)) {
		ChromePhp::log("Query accepted.");
		$num_rows = $data->num_rows;
		while ($row=mysqli_fetch_assoc($data)) {
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