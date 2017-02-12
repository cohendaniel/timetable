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
		console.log(document.referrer);
		if (document.referrer == "http://localhost:8080/TimeTable/web/manage.php") {
			populateEventPage();
		}
		$("#add-item-btn").click(function() {
			var table = $("#add-item-btn").closest("table");
			addRow(table);
		});
		$("#make-sch-button").click(function() {
			runScheduler();
		});
		$("#user-email").blur(function() {
			localStorage.setItem("email", $("#user-email").val());
		});
		$("#block-form").submit(function() {
			var rows = $("#block-form").find("tr.block-data");
			var num_rows = rows.length;
			$("#num-rows").val(num_rows);
			//console.log(num_rows);
		});
	});
	</script>
</head>
<body class = "no-margin">
	<ul id="menu-vertical">
		<li id="logo"><b>TimeTable</b></li>
		<li><a href="create.php">create</a></li>
		<li><a href="manage.php">manage</a></li>
		<li><a href="#0">help</a></li>
		<div id="vertical-small-link">
			<li><a href="#0">home</a></li>
			<li><a href="#0">about</a></li>
			<li><a href="#0">donate</a></li>
			<li><a href="#0">contact</a></li>
		<div>
	</ul>
	<div id="main-body">
		<form class="input-table" id="block-form" method="post">
			<h2 class="event-title">
				<?php echo $_SESSION["eventName"]?>
			</h2>
			<table id="block-table">
				<tr>
					<th></th>
					<th>Name</th>
					<th>Date</th>
					<th>Time</th>
					<th>Slots</th>
				</tr>
				<tr class="block-data" name="">
					<td class="block-number b">1</td>
					<td><input class="input-form" id="block-name1" type="text" name="block-name1" onblur="updateBlockName(this);"/></td>
					<td>
						<input class="third-width input-form" id="block-month1" type="text" name="block-month1" placeholder="MM"/><span class="input-form b">/</span>
						<input class="third-width input-form" id="block-day1" type="text" name="block-day1" placeholder="DD"/><span class="input-form b">/</span>
						<input class="third-width input-form" id="block-year1" type="text" name="block-year1" placeholder="YYYY"/>
					</td>
					<td>
						<input class="third-width input-form" id="block-hour1" type="text" name="block-hour1"/><span class="input-form b">:</span>
						<input class="third-width input-form" id="block-minute1" type="text" name="block-minute1"/>
						<select class="third-width input-form" id="block-ampm1" type="text" name="block-ampm1"/>
							<option selected="selected" value="am">AM</option>
							<option value="pm">PM</option>
						</select>
					</td>
					<td><input id="block-slots1" class="input-form block-slot" type="text" name="block-slots1" /></td>
				</tr>
				<tr class="block-data" name="">
					<td class="block-number b">2</td>
					<td><input class="input-form" id="block-name2" type="text" name="block-name2" onblur="updateBlockName(this);"/></td>
					<td>
						<input class="third-width input-form" id="block-month2" type="text" name="block-month2" placeholder="MM"/><span class="input-form b">/</span>
						<input class="third-width input-form" id="block-day2" type="text" name="block-day2" placeholder="DD"/><span class="input-form b">/</span>
						<input class="third-width input-form" id="block-year2" type="text" name="block-year2" placeholder="YYYY"/>
					</td>
					<td>
						<input class="third-width input-form" id="block-hour2" type="text" name="block-hour2"/><span class="input-form b">:</span>
						<input class="third-width input-form" id="block-minute2" type="text" name="block-minute2"/>
						<select class="third-width input-form" id="block-ampm2" type="text" name="block-ampm2"/>
							<option selected="selected" value="am">AM</option>
							<option value="pm">PM</option>
						</select>
					</td>
					<td><input id="block-slots2" class="input-form block-slot" type="text" name="block-slots2" /></td>
				</tr>
				<tr class="block-data" name="">
					<td class="block-number b">3</td>
					<td><input class="input-form" id="block-name3" type="text" name="block-name3" onblur="updateBlockName(this);"/></td>
					<td>
						<input class="third-width input-form" id="block-month3" type="text" name="block-month3" placeholder="MM"/><span class="input-form b">/</span>
						<input class="third-width input-form" id="block-day3" type="text" name="block-day3" placeholder="DD"/><span class="input-form b">/</span>
						<input class="third-width input-form" id="block-year3" type="text" name="block-year3" placeholder="YYYY"/>
					</td>
					<td>
						<input class="third-width input-form" id="block-hour3" type="text" name="block-hour3"/><span class="input-form b">:</span>
						<input class="third-width input-form" id="block-minute3" type="text" name="block-minute3"/>
						<select class="third-width input-form" id="block-ampm3" type="text" name="block-ampm3"/>
							<option selected="selected" value="am">AM</option>
							<option value="pm">PM</option>
						</select>
					</td>
					<td><input id="block-slots3" class="input-form block-slot" type="text" name="block-slots3" /></td>
				</tr>
				<tr class="block-data" name="">
					<td class="block-number b">4</td>
					<td><input class="input-form" id="block-name4" type="text" name="block-name4" onblur="updateBlockName(this);"/></td>
					<td>
						<input class="third-width input-form" id="block-month4" type="text" name="block-month4" placeholder="MM"/><span class="input-form b">/</span>
						<input class="third-width input-form" id="block-day4" type="text" name="block-day4" placeholder="DD"/><span class="input-form b">/</span>
						<input class="third-width input-form" id="block-year4" type="text" name="block-year4" placeholder="YYYY"/>
					</td>
					<td>
						<input class="third-width input-form" id="block-hour4" type="text" name="block-hour4"/><span class="input-form b">:</span>
						<input class="third-width input-form" id="block-minute4" type="text" name="block-minute4"/>
						<select class="third-width input-form" id="block-ampm4" type="text" name="block-ampm4"/>
							<option selected="selected" value="am">AM</option>
							<option value="pm">PM</option>
						</select>
					</td>
					<td><input id="block-slots4" class="input-form block-slot" type="text" name="block-slots4" /></td>
				</tr>
				<tr class="block-data" name="">
					<td class="block-number b">5</td>
					<td><input class="input-form" id="block-name5" type="text" name="block-name5" onblur="updateBlockName(this);"/></td>
					<td>
						<input class="third-width input-form" id="block-month5" type="text" name="block-month5" placeholder="MM"/><span class="input-form b">/</span>
						<input class="third-width input-form" id="block-day5" type="text" name="block-day5" placeholder="DD"/><span class="input-form b">/</span>
						<input class="third-width input-form" id="block-year5" type="text" name="block-year5" placeholder="YYYY"/>
					</td>
					<td>
						<input class="third-width input-form" id="block-hour5" type="text" name="block-hour5"/><span class="input-form b">:</span>
						<input class="third-width input-form" id="block-minute5" type="text" name="block-minute5"/>
						<select class="third-width input-form" id="block-ampm5" type="text" name="block-ampm5"/>
							<option selected="selected" value="am">AM</option>
							<option value="pm">PM</option>
						</select>
					</td>
					<td><input id="block-slots5" class="input-form block-slot" type="text" name="block-slots5" /></td>
				</tr>
			</table>
			<input class="cycle-block-btn" value="< Last" type="button" onclick="cycleTable(-1)"/>
			<input class="cycle-block-btn" value=" Next >" type="button" onclick="cycleTable(1)"/>
			<div id="send-save-btns" class="center">
				<input id="submit-block-btn" class="admin-button" type="submit" name="submit-block" value="Send"/>
				<input id="save-block-btn" class="admin-button" type="submit" name="save-survey" value="save for later"/>
				<!--<input id="make-sch-button" class="admin-button" type="button" name="make-schedule" value ="Generate Schedule" />-->
			</div>
			<input type="hidden" id="num-rows" name="num-rows" value="1"/>
		</form>
	</div>
</body>
</html>