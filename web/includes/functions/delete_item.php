<?php
session_start();
require_once '/../../ChromePhp.php';
//require_once('./includes/database/DB.php');
//local windows access -- use below instead
require_once('/../database/DB_local.php');

if (isset($_POST)) {
	ChromePhp::log('entered delete_item function');
	$itemRow = $_POST['itemRow'];
	$userID = $_SESSION['userID'];
	$eventID = $_SESSION['eventID'];
	
	
	$result = $connection->query("SELECT ITEM_ID FROM item WHERE EVENT_ID = $eventID");
	mysqli_data_seek($result, $itemRow);
	$itemInfo = $result->fetch_array(MYSQLI_NUM);
	$itemID = $itemInfo[0];
	
	$query = "DELETE FROM item WHERE ITEM_ID = $itemID"; 

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