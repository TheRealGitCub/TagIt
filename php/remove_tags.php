<?php
	
	require_once("api_auth.php");

	$tags = explode(",", $_GET["tags"]);

	foreach($tags as $t) {
		$rm = $f->photos_removeTag($t);
	}

?>