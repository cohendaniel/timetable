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
	<link href='https://fonts.googleapis.com/css?family=Cabin:500' rel='stylesheet' type='text/css'>
	<script type = "text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="./includes/scripts/scripts.js"></script>
	<script>
	
	</script>
</head>
<body class = "no-margin">
	<ul id="menu-vertical">
		<li id="logo"><b>TimeTable</b></li>
		<li><a href="#0">create</a></li>
		<li><a href="#0">manage</a></li>
		<li><a href="#0">help</a></li>
		<div id="vertical-small-link">
			<li><a href="#0">home</a></li>
			<li><a href="#0">about</a></li>
			<li><a href="#0">donate</a></li>
			<li><a href="#0">contact</a></li>
		<div>
	</ul>
	<form id="create-form" method="post">
		<h2 id="create-event-name">Name your event</h2>
		<div>
			<input id="create-event-input" type="text" name="event-name"/>
		</div>
		<input id="create-event-btn" type="submit" name="create-event" value="next"/>
	</form>
</body>