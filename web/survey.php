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
	<form>
		<table>
			<tr>
				<th>Name</th>
				<th>Availability</th>
				<th>Number of slots</th>
			</tr>
			<tr>
				<td><input type="text" /></td>
				<td>
					<select multiple>
						<option>Tuesday</option>
						<option>Wednesday</option>
						<option>Thursday</option>
					</select>
				</td>
				<td><input type="text" /></td>
			</tr>
		</table>
	</form>
</body>