<!DOCTYPE html>
<?php
//require_once('includes/database/DB.php');

//local windows access -- use below instead
require_once(dirname(__FILE__) . '/includes/database/DB_local.php');
require_once(dirname(__FILE__) . '/includes/init.php');
?>
<html class = "no-margin">
<head>
	<title>TimeTable</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href='https://fonts.googleapis.com/css?family=Cabin:500' rel='stylesheet' type='text/css'>
	<script type = "text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="./includes/scripts/scripts.js"></script>
	<script>
	$(document).ready(function() {
		addAvailEvents();
	});
	</script>
</head>
<body class = "no-margin">
	<ul id="menu-vertical">
		<li id="logo"><b>TimeTable</b></li>
		<li><a href="create.php">create</a></li>
		<li><a href="#0">manage</a></li>
		<li><a href="#0">help</a></li>
		<div id="vertical-small-link">
			<li><a href="#0">home</a></li>
			<li><a href="#0">about</a></li>
			<li><a href="#0">donate</a></li>
			<li><a href="#0">contact</a></li>
		<div>
	</ul>
	<div class="overlay" hidden="true">
		<div id="manage-response-overlay" class="center-vertical">
			<p>Responses</p>
			<table id="manage-response-table">
				<tr id="manage-response-row-0">
					<td>1</td>
					<td id="manage-response-name-0">Name</td>
					<td id="manage-response-delete-0"><button type="button" onclick="deleteItem(this)">delete</button></td>
				</tr>
			</table>
			<button type="button" onclick="closeOverlay()">Close</button>
		</div>
	</div>
	<h1 id="manage-title">Manage events</h1>
	<table id="manage-table">
		<tr id="manage-table-header">
			<th>Event</th>
			<th>Responses</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<tr class="manage-table-row">
			<td id="manage-table-event-0"></td>
			<td id="manage-table-responses-0"></td>
			<td id="manage-table-edit-0"><a href="javascript:void(0)" onclick="javascript:openEventPage(this)">edit</a></td>
			<td id="manage-table-delete-0"><a href="javascript:void(0)" onclick="javascript:deleteEvent(this)">delete</a></td>
			<td id="manage-table-open-0"><button type="button" onclick="openOverlay(this)">+</button></td>
			<td id="manage-table-generate-0"><button type="button" onclick="runScheduler(this)">✓</button></td>
		</tr>
	</table>
	<div id="report"></div>
</body>
</html>