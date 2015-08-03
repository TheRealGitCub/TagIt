<?php

	require_once("api_auth.php");

	$get_photos = $f->photosets_getPhotos($album_id);

	$photos = $get_photos["photoset"]["photo"];

	foreach ($photos as $i => $p) {
		$sizes = $f->photos_getSizes($p["id"]);
		$photos[$i]["thumb_url"] = $sizes[1]["source"];
	}

	$album = array(
		"name" => $get_photos["photoset"]["title"],
		"photos" => $photos
	);

	
?>