<?php
	
	require_once("get_tags.php");

	$photos = $_GET["photos"];
	$photos = explode(",", $photos);

	$common_tags_list = array();
	$common_tags = array();
	$all_tags = array();

	foreach ($photos as $p) {
		$tags_api = getTags($p, $f);

		$tags = array();

		foreach ($tags_api as $t) {
			$tag = $t["_content"];

			$all_tags[$tag][] = $t["id"];

			$tags[$tag] = $t["raw"];
		}

		if (empty($common_tags_list)) {
			$common_tags_list = $tags;
		}
		else {
			$common_tags_list = array_intersect($common_tags_list, $tags);
		}
	}

	foreach ($all_tags as $t => $ids) {
		if (isset($common_tags_list[$t])) {
			$common_tags[] = array (
				"content" => $t,
				"raw" => $common_tags_list[$t],
				"ids" => $ids
			);
		}
	}
	
	foreach ($common_tags as $tag) {

		?>
			
			<button type="button" class="btn btn-xs btn-default tag"
				data-tag-content="<?php echo $tag["content"]?>" 
				data-tag-ids="<?php echo implode(",", $tag["ids"]) ?>">
					<?php echo $tag["raw"] ?> <span class="tag-remove"><i class="fa fa-times"></i></span>
			</button>
		<?php

	}

?>

