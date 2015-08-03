<?php

	require_once("api_auth.php");

	if (!isset($album_page)) {
		$album_page = 1;
	}

	//$user_id = "32753800@N03";
	$user_id = NULL;
	
	$get_albums = $f->photosets_getList($user_id,$album_page,12);

	$album_info = array();

	$i = 0;

	foreach ($get_albums["photoset"] as $album) {
		$albums["albums"][$i] = $album;
		$primary_sizes = $f->photos_getSizes($album["primary"]);

		$albums["albums"][$i]["thumb_url"] = $primary_sizes[1]["source"];
		$i++;

	}

	$albums["pages"] = $get_albums["pages"];

?>