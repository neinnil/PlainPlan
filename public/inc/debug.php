<?php
	function myDebug($contents) {
		error_log($contents, 3, "/var/log/php7/my-errors.log");
	}
?>
