<?php
	
	session_start();

	$redirect = $_SESSION["redirect"];
	session_destroy();

	header("Location: " . $redirect);

?>