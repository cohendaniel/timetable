<?php
require_once '/../../ChromePhp.php';
//require_once('./includes/database/DB.php');
//local windows access -- use below instead
require_once('/../database/DB_local.php');

if (isset($_POST["login-btn"])) {
	ChromePhp::log('pressed login button');
	$username = $_POST['login-user'];
	if(check_user($connection, $username, $_POST['login-password'])) {
		ChromePhp::log("Correct username/password combo");
		$_SESSION["username"]=$username;
		if ($result = $connection->query("SELECT USER_ID FROM user WHERE USER_EMAIL = '$username'")) {
			$row = $result->fetch_array(MYSQLI_NUM);
			$userID = $row[0];
			$_SESSION["userID"]=$userID;
			ChromePhp::log($userID);
		}
		header('Location: manage.php');
		return true;
	}
	else {
		return false;
	}
}
else {
	ChromePhp::log("not posted");
	return false;
}

function check_user($connection, $username, $password) {
	if(!empty($username) && !empty($password)) {
		$t_username = mysqli_real_escape_string($connection, $username);
		$t_password = mysqli_real_escape_string($connection, $password);
		
		ChromePhp::log("USERNAME: ".$t_username." PASSWORD:".$t_password);
		
		$query = "SELECT * FROM user WHERE USER_PASSWORD = '$t_password' AND USER_EMAIL ='$t_username'";
		
		if ($result = $connection->query($query)) {
			ChromePhp::log("Query to 'user' accepted.<br/>");
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$result->close();
			if ($t_password == $row["USER_PASSWORD"]) {
				return true;
			}
			else {
				ChromePhp::log("Incorrect username/password combo.<br/>");
				return false;
			}
		} 
		else {
			ChromePhp::error("Query to 'user' not accepted.<br/>");
			return false;
		}
	} 
	else {
		echo ChromePhp::error("User info not filled out.");
		return false;
	}
}

?>