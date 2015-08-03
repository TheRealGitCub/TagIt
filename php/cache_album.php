<?php

	require_once('api_settings.php');
	require_once('api_auth.php');

	$album_page = (isset($_GET["album_page"])? $_GET["album_page"] : 1);
	require_once('get_albums.php');

	echo json_encode($albums);

?>