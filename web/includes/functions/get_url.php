<?php
session_start();
if (isset($_SESSION["eventURL"])) {
	echo $_SESSION["eventURL"];
}
else {
	print_r($_SESSION);
	echo "ERROR";
}
?>