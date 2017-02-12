<!DOCTYPE html>
<?php

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
			var prefix = "http://localhost/Timetable/web/survey.php";
			var email = localStorage.getItem("email");
			var url = "./includes/functions/get_url.php";
			data = {'email': email};
			$.get(url, data, function(output, status) {
				document.getElementById('url').innerHTML = prefix + "?id=" + output;
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
	<div id="show-url">
		<h2 class="center-vertical">Find your survey at:</h2>
		<div class="center-vertical" id="url">
		</div>
	</div>
</body>