<?php
//require_once('../database/DB.php');
//local Windows access -- use below instead
require_once(dirname(__FILE__) . '/../database/DB_local.php');
require_once '/../../ChromePhp.php';
if (isset($_POST['buttonName'])) {
	ChromePhp::log('pressed schedule button');
	make_schedule($connection);
}
function make_schedule($connection) {
	if ($data = mysqli_query($connection, "SELECT * FROM item")) {
		$path_item = getcwd().'\output_item.csv';
		$output_item = fopen("$path_item", 'w');
		while ($row = mysqli_fetch_assoc($data)) {
			fputcsv($output_item, $row);
		}
		fclose($output_item);
	}
	if ($data = mysqli_query($connection, "SELECT * FROM block")) {
		$path_block = getcwd().'\output_block.csv';
		$output_block = fopen("$path_block", 'w');
		while ($row = mysqli_fetch_assoc($data)) {
			fputcsv($output_block, $row);
		}
		fclose($output_block);
	}
	//local Windows access -- use below instead

	$return = shell_exec('..\..\..\Debug\TimeTable.exe "'.$path_block.'" "'.$path_item.'"');
	
	echo $return;
	return true;
}

?>