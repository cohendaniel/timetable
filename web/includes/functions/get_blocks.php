<?php
session_start();
require_once '/../../ChromePhp.php';
//require_once('./includes/database/DB.php');
//local windows access -- use below instead
require_once('/../database/DB_local.php');

if (isset($_POST)) {
	ChromePhp::log('entered get_blocks function');
	
	$eventURL = $_SESSION["eventURL"];
	$result = $connection->query("SELECT EVENT_ID, EVENT_NAME FROM event WHERE EVENT_URL = '$eventURL'");
	$eventID = $result->fetch_array(MYSQLI_NUM)[0];
	$eventName = $result->fetch_array(MYSQLI_NUM)[1];
	$_SESSION["eventID"] = $eventID;
	$_SESSION["eventName"] = $eventName;
	
	$query = "SELECT BLOCK_NAME, BLOCK_DATE, BLOCK_TIME FROM block WHERE EVENT_ID = '$eventID'"; 
	ChromePhp::log($query);
	if ($data = mysqli_query($connection, $query)) {
		ChromePhp::log("Query accepted.");
		while ($row=mysqli_fetch_assoc($data)) {
			//echo $row->BLOCK_NAME.",".$row->BLOCK_DATE",".$row->BLOCK_TIME
			//ChromePhp::log($row->BLOCK_NAME, $row->BLOCK_DATE, $row->BLOCK_TIME);
			$rows[]=$row;
		}
		//ChromePhp::log(json_encode(mysqli_fetch_assoc($data)));
		echo json_encode($rows);
	} 
	else {
		ChromePhp::error("Query not accepted.<br/>");
		return NULL;
	}
}

?>