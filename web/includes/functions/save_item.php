<?php
require_once '/../../ChromePhp.php';
//require_once('./includes/database/DB.php');
//local windows access -- use below instead
require_once('/../database/DB_local.php');
//print_r($_SESSION);
//print_r($_POST);

if (isset($_POST["submit-item"])) {
	ChromePhp::log('SAVE ITEM PRESSED BUTTON');
	
	$name = mysqli_real_escape_string($connection, $_POST['item-name1']);
	$num_slots = mysqli_real_escape_string($connection, $_POST['item-slots1']);
	$eventID = $_SESSION['eventID'];
	
	ChromePhp::log($eventID);
	$item_query = "INSERT INTO item VALUES (NULL, '$eventID', '$name', '$num_slots', 'NULL', NULL, NULL)";
	if ($run = mysqli_query($connection, $item_query)) {
		ChromePhp::log("Insert to 'item' accepted.<br/>");
	} else {
		ChromePhp::error("Insert to 'item' not accepted.<br/>");
		return false;
	}
	$itemID = $connection->insert_id;
	
	$block_query = "SELECT * FROM block WHERE EVENT_ID = '$eventID'";
	if ($result = mysqli_query($connection, $block_query)) {
		$num_rows = $result->num_rows;
		$avail = "";
		for($i=0; $i<$num_rows; $i++) {
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$blockID = $row["BLOCK_ID"];
			ChromePhp::log($blockID);
			ChromePhp::log($itemID);
			if (isset($_POST['item-block-check'.($i+1)])) {
				if($connection->query("INSERT INTO map_item_block VALUES ('$itemID', '$blockID')")) {
					ChromePhp::log("insert map_item_block accepted");
				}
				else {
					ChromePhp::error("insert map_item_block not accepeted");
				}
				$avail = $avail."1";
			}
			else {
				$avail = $avail."0";
			}
			//ChromePhp::log($row);
		}
		//ChromePhp::log("AVAIL: ".$avail);
	}
	//item id, user id, item name, num slots, avail, block, slot
}
else {
	//ChromePhp::log('SAVE ITEM DID NOT PRESS BUTTON');
	return;
}

function save_avail($connection, $name, $date, $time, $numSlots, $userID) {
	ChromePhp::log($name, $date, $time, $numSlots, $userID);
	
	if(!empty($name) && !empty($date) && !empty($time) && !empty($numSlots)) {
		$name = mysqli_real_escape_string($connection, $name);
		$date = mysqli_real_escape_string($connection, $date);
		$time = mysqli_real_escape_string($connection, $time);
		$numSlots = mysqli_real_escape_string($connection, $numSlots);

		$query = "INSERT INTO block VALUES (NULL, '$name', '$date', '$time', '$numSlots', $userID)"; 

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

//function validate_item($