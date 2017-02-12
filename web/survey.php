<!DOCTYPE html>
<?php
//require_once('includes/database/DB.php');

//local windows access -- use below instead
require_once(dirname(__FILE__) . '/includes/database/DB_local.php');
require_once(dirname(__FILE__) . '/includes/init.php');

$_SESSION["eventURL"] = $_GET["id"];
?>
<html>
<head>
	<title>TimeTable</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href='https://fonts.googleapis.com/css?family=Cabin:500' rel='stylesheet' type='text/css'>
	<script type = "text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="./includes/scripts/scripts.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.js"></script>
	<script>
	$(document).ready(function() {
		addAvailOptions();
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
	<h2 class="center-vertical event-title">
		<?php echo $_SESSION["eventName"]?>
	</h2>
	<form id="survey-form" class="center-vertical" method="post">
		<div class="row-spacer"></div>
		<table class="center-vertical" id="survey-table">	
			<tr>
				<th>Block</th>
				<th>Date</th>
				<th>Time</th>
				<th></th>
			</tr>
			<tr id="item-blocks">
				<td id="item-block-name1"/></td>
				<td id="item-block-date1"/></td>
				<td id="item-block-time1"/></td>
				<td><input type="checkbox" name="item-block-check1"/></td>
			</tr>
		</table>
		<div class="row-spacer"></div>
		<div>
			<input class="input-form" type="text" name="item-slots1" placeholder="Number of shifts"/>
		</div>
		<div class="row-spacer"></div>
		<div>
			<input class="input-form" type="text" name="item-name1" placeholder="Name"/>
		</div>
		<div class="row-spacer"></div>
		<input id="survey-submit-btn" type="submit" name="submit-item" value="Submit"/>
	</form>
</body>