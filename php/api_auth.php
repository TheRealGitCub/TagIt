<?php

	session_start();

	require_once('api_settings.php');
	require_once('phpflickr/phpFlickr.php');

	$f = new phpFlickr($api_key, $api_secret);

	$f->enableCache("db", "mysql://phpflickr:PASSWORD@localhost/flickr", 86400);

	if (!isset($_SESSION["phpFlickr_auth_token"]) || empty($_SESSION["phpFlickr_auth_token"])) {
		$api_perms = "write";
		$api_sig = $api_secret . "api_key" . $api_key . "perms" . $api_perms;
		$api_sig = md5($api_sig);
		$url = "http://flickr.com/services/auth/?api_key=" . $api_key . "&perms=". $api_perms ."&api_sig=" . $api_sig;
	}
	else {
		$_SESSION["redirect"] = "/";
		$authToken = $_SESSION["phpFlickr_auth_token"]["_content"];

		$f->setToken($authToken);

	}

?>
