<?php
require_once '/../../ChromePhp.php';
//print_r($_POST);
//require_once('./includes/database/DB.php');
//local windows access -- use below instead
require_once('/../database/DB_local.php');

if (isset($_POST["user-create-btn"])) {
	ChromePhp::log('pressed create user button');
	if(create_user($connection, $_POST['login-new-user'], $_POST['login-new-password'])) {
		ChromePhp::log("account successfully created");
		header('Location: create.php');
		return true;
	}
	else {
		return false;
	}
}
else {
	return;
}

function create_user($connection, $username, $password) {
	if(!empty($username) && !empty($password)) {
		$username = mysqli_real_escape_string($connection, $username);
		$password = mysqli_real_escape_string($connection, $password);
		
		$query = "INSERT INTO user VALUES (NULL, '$username', '$password')";
		
		if ($result = $connection->query($query)) {
			ChromePhp::log("Query to 'user' accepted.<br/>");
			$query = "SELECT USER_ID FROM user WHERE USER_EMAIL = '$username'";
			if ($result = $connection->query($query)) {
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$_SESSION["userID"] = $row["USER_ID"];
				$_SESSION["username"] = $row["USER_EMAIL"];
			}
			return true;
		} 
		else {
			ChromePhp::error("Query to 'user' not accepted.<br/>");
			return false;
		}
	} 
	else {
		echo ChromePhp::error("User info not filled out.<br/>");
		return false;
	}
}

?>