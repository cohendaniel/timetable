<!DOCTYPE html>
<?php
//require_once('includes/database/DB.php');

//local windows access -- use below instead
require_once(dirname(__FILE__) . '/includes/database/DB_local.php');
require_once(dirname(__FILE__) . '/includes/init.php');
?>
<html>
<head>
	<title>TimeTable</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type = "text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="./includes/scripts/scripts.js"></script>
	<script>
	$(document).ready(function() {
		$("#add-block-btn").click(function() {
			var table = $("#add-block-btn").closest("table");
			addRow(table);
		});
		$("#add-item-btn").click(function() {
			var table = $("#add-item-btn").closest("table");
			addRow(table);
		});
		$("#make-sch-button").click(function() {
			runScheduler();
		});
	});
	</script>
</head>
<body class = "no-margin">
	
	<ul id="menu">
		<li id="logo"><b>TimeTable</b></li>
		<li class="link-space"><a href="#0">home</a></li>
		<li class="link-space"><a href="#0">about</a></li>
		<li class="link-space"><a href="#0">donate</a></li>
		<li class="link-space"><a href="#0">contact</a></li>
	</ul>

	<div style="text-align: center;">
		<input id="make-sch-button" type="button" name="make-schedule" value ="Generate Schedule" />
	</div>
	<div id="left-column-headers">
		<h2 class="big-break">Step 1: <b>Build Blocks</b></h2>
		<h2 class="big-break">Step 2: <b>Initialize Items</b></h2>
		<h2 class="big-break">Step 3: <b>Enter Info</b></h2>
	</div>
	<div id="main-body">
		<form class="big-break" id="block-form" method="post">
			<table id="block-table" class="yellow-background inputTable">
				<tr>
					<th><input id="add-block-btn" type="button" name="add-block-btn" value="Add" /></th>
					<th>Name</th>
					<th>Date</th>
					<th>Time</th>
					<th>Number of slots</th>
				</tr>
				<tr id="block-data" name="">
					<td>1</td>
					<td><input id="block-name" type="text" name="block-name1" onblur="updateBlockName(this);"/></td>
					<td><input type="text" name="block-date1" /></td>
					<td><input type="text" name="block-time1" /></td>
					<td><input type="text" name="block-slots1" /></td>
				</tr>
			</table>
			<input id="submit-block-btn" type="submit" name="submit-block" value="Submit"/>
		</form>
		<div id="report">
		This is the report.
		</div>
		<form class="big-break" id="item-form" method="post">
			<table id="item-table" class="inputTable yellow-background">
				<tr>
					<th><input id="add-item-btn" type="button" name="add-item-btn" value="Add" /></th>
					<th>Name</th>
					<th>Availability</th>
					<th>Number of slots</th>
				</tr>
				<tr id="item-data">
					<td>1</td>
					<td><input type="text" name="item-name1" /></td>
					<td><select multiple></select></td>
					<td><input type="text" name="item-slots1" /></td>
				</tr>
			</table>
			<input id="submit-item-btn" type="submit" name="submit-item" value="Submit"/>
		</form>
	</div>
</body>
</html>