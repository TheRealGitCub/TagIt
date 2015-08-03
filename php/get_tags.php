<?php

	require_once("api_auth.php");

	function getTags($photo_id, $f) {
		$info = $f->photos_getInfo($photo_id);
		$tags = $info["photo"]["tags"]["tag"];

		return $tags;
	}

	if (isset($photo_id)) {
		$tags = getTags($photo_id, $f);
	}

?>