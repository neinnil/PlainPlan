<?php
if (empty($_SESSION)) {
	session_start();
}

function checkSessionValid($key, $value) {
	if(isset($_SESSION[$key])){
		if ($_SESSION[$key] == $value) {
			return true;
		}
	}
	return false;
}

?>
