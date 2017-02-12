<!DOCTYPE html>
<?php
//require_once('includes/database/DB.php');

//local windows access -- use below instead
require_once(dirname(__FILE__) . '/includes/database/DB_local.php');
require_once(dirname(__FILE__) . '/includes/init.php');
//require_once(dirname(__FILE__) . '/includes/functions/authenticate.php');
?>
<html>
<head>
	<title>TimeTable</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href='https://fonts.googleapis.com/css?family=Cabin:500' rel='stylesheet' type='text/css'>
	<script type = "text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="./includes/scripts/scripts.js"></script>
	<script>
	$(document).ready(function() {
		if (document.referrer == "http://localhost:8080/TimeTable/web/home.php") {
			$("#welcome-error").html("Incorrect username or password");
		}
	});
	</script>
</head>
<body class = "no-margin">
	<ul id="menu">
		<li id="logo"><b>TimeTable</b></li>
		<li><a href="#0">home</a></li>
		<li><a href="#0">about</a></li>
		<li><a href="#0">donate</a></li>
		<li><a href="#0">contact</a></li>
	</ul>
	<form id="welcome-form" method="post">
		<h2 id="welcome-message" class="color1">TimeTable</h2>
		<h4 id="welcome-submessage" class="color3">a timely event scheduler</h4>
		<div id="welcome-user-login">
			<input id="welcome-login-username" type="text" name="login-user" placeholder="email"/>
			<input id="welcome-login-password" type="password" name="login-password" placeholder="password"/>
			<div id="welcome-error"></div>
			<input id="welcome-login-btn" class="admin-button" type="submit" name="login-btn" value="login"/>
		</div>
		<div id="welcome-user-create">
			<p>Or create a new account</p>
			<input id="welcome-login-new-user" type="text" name="login-new-user" placeholder="email"/>
			<input id="welcome-login-new-password" type="text" name="login-new-password" placeholder="password"/>
			<input id="welcome-user-create-btn" class="admin-button" type="submit" name="user-create-btn" value="create"/>
		</div>
	</form>
</body>