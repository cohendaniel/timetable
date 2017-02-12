<?php
session_start();
//require_once('../database/DB.php');
//local Windows access -- use below instead
require_once(dirname(__FILE__) . '/../database/DB_local.php');
require_once '/../../ChromePhp.php';
if (isset($_GET)) {
	ChromePhp::log('pressed schedule button');
	make_schedule($connection);
}
function make_schedule($connection) {
	$eventRow = $_GET['row'];
	$userID = $_SESSION['userID'];
	
	$result = $connection->query("SELECT EVENT_ID, EVENT_NAME FROM event WHERE USER_ID = $userID");
	mysqli_data_seek($result, $eventRow);
	$eventInfo = $result->fetch_array(MYSQLI_NUM);
	$eventID = $eventInfo[0];
	$eventName = $eventInfo[1];
	
	$result = $connection->query("SELECT BLOCK_ID FROM block WHERE EVENT_ID = $eventID");
	$blocks = array();
	while ($row = $result->fetch_array(MYSQLI_NUM)) {
		$blocks[] = $row[0];
	}
	$num_items = 0;
	$num_duplicates = 0;
	if ($data = mysqli_query($connection, "SELECT * FROM item WHERE EVENT_ID = $eventID")) {
		$num_items = $data->num_rows;
		$path_item = '..\output\output_item.csv';
		$output_item = fopen("$path_item", 'w');
		while ($row = mysqli_fetch_assoc($data)) {
			$avail = create_avail($connection, $row, $blocks);
			$row['ITEM_AVAILABILITY'] = $avail;
			fputcsv($output_item, $row);
		}
		fclose($output_item);
		if ($data = $connection->query("SELECT SUM(ITEM_NUM_SLOTS) FROM item")) {
			$num_duplicates = $data->fetch_array(MYSQLI_NUM)[0];
		}
	}
	$num_blocks = 0;
	$num_slots = 0;
	if ($data = mysqli_query($connection, "SELECT * FROM block WHERE EVENT_ID = $eventID")) {
		$num_blocks = $data->num_rows;
		$path_block = '..\output\output_block.csv';
		$output_block = fopen("$path_block", 'w');
		while ($row = mysqli_fetch_assoc($data)) {
			fputcsv($output_block, $row);
		}
		fclose($output_block);
		if ($data = $connection->query("SELECT SUM(BLOCK_NUM_SLOTS) FROM block")) {
			$num_slots = $data->fetch_array(MYSQLI_NUM)[0];
		}
	}

	//local Windows access -- use below instead

	$return = shell_exec('..\..\..\Debug\TimeTable.exe "'.$path_block.'" "'.$path_item.'" '.$num_duplicates.' '.$num_items.' '.$num_blocks.' '.$num_slots.'');
	
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.$eventName.".csv".'"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');

	echo $return;
	return true;
}

function create_avail($connection, $item, $blocks) {
	$item_id = $item["ITEM_ID"];
	$result = $connection->query("SELECT BLOCK_ID FROM map_item_block WHERE ITEM_ID = '$item_id'");
	$avail = "";
	$map_item = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$map_item[] = $row["BLOCK_ID"];
	}
	foreach ($blocks as $block) {
		if (in_array($block, $map_item)) {
			$avail = $avail."1";
		}
		else {
			$avail = $avail."0";
		}
	}
	ChromePhp::log($avail);
	if($connection->query("UPDATE item SET ITEM_AVAILABILITY = '$avail' WHERE ITEM_ID = '$item_id'")) {
		ChromePhp::log("item avail update accepted");
	}
	else {
		ChromePhp::log("item avail update not accepted");
	}
	return $avail;
}

?>