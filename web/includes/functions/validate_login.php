<?php
	function validate_login($username, $password) {
		if ($username == 'admissions' && $password == 'bowdoin') {
			return true;
		}
		else return false;
	}
?>