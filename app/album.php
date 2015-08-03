<?php 
	session_start();

	require_once('../php/api_settings.php');
	require_once('../php/api_auth.php');

	$album_id = $_GET["album_id"];

	require_once('../php/get_album_photos.php');

	if (isset($_SESSION["last_album_page"])) {
		$albums_link_num = $_SESSION["last_album_page"];
	}
	else {
		$albums_link_num = 1;
	}

?>

<!doctype html>
<html>
<head>
	
	<title>TagIt | Bulk Flickr Tag Editor</title>
	
	<?php include("../includes/assets.php") ?>
	
	<script type="text/javascript" src="/js/ajaxq.js"></script>

	<script type="text/javascript">

	var selectedPhotos = [];
		var ajaxBusy = false;

		$(document).ready(function() {
			$(".photo-thumb").click(function() {
				$(this).toggleClass('thumb-selected');
				var selected = $(this).hasClass('thumb-selected');
				var photoID = $(this).data('photo-id');

				if (selected) {
					selectedPhotos.push(photoID);
				}
				else {
					var index = selectedPhotos.indexOf(photoID);
					selectedPhotos.splice(index, 1);
				}

				if (selectedPhotos.length > 0) {

					if ($.ajaxq.isRunning("tagsQueue")) {
						$.ajaxq.abort("tagsQueue");
					}

					$.ajaxq("tagsQueue", {
						url: '/php/ajax_common_tags.php',
						type: 'GET',
						dataType: 'html',
						data: {photos: selectedPhotos.toString()},
						beforeSend: function() {
							$("#tags").empty();
							$("#tags").addClass('hidden');
							$("#tags-overlay-outer").removeClass('hidden');
							ajaxBusy = true;
						}
					})
					.done(function(data) {
						console.log("success");
						$("#tags").html(data);

						$(".tag-remove").click(function () {
							var tag = $(this).closest(".btn");
							tag.toggleClass("tag-to-remove").toggleClass('btn-default').toggleClass('btn-danger');;
							tag.find(".fa").toggleClass("fa-times").toggleClass('fa-undo');
						});
						$("#tags").removeClass('hidden');

						$(".has-tooltip").tooltip();
					})
					.fail(function() {
						console.log("error");
					})
					.always(function() {
						$("#tags").removeClass('hidden');
						$("#tags-overlay-outer").addClass('hidden');
						console.log("complete");
						ajaxBusy = false;
					});

				}

				else {
					if ($.ajaxq.isRunning("tagsQueue")) {
						$.ajaxq.abort("tagsQueue");
					}
					$("#tags").empty();
				}
				

			});

			$("#remove-submit").click(function () {
				$(".tag-to-remove").each(function(index, el) {
					$.ajax({
						url: '/php/remove_tags.php',
						type: 'GET',
						data: {tags: $(this).data('tag-ids')},
					})
					.done(function() {
						console.log("success");
						$.ajaxq("tagsQueue", {
							context: this,
							url: '/php/ajax_common_tags.php',
							type: 'GET',
							dataType: 'html',
							data: {photos: selectedPhotos.toString()},
							beforeSend: function() {
								$("#remove-submit").addClass("disabled");
							}
						})
						.done(function(data) {
							console.log("success");
							$("#tags").html(data);
							$("#remove-submit").removeClass("disabled");

							$(".tag-remove").click(function () {
								var tag = $(this).closest(".btn");
								tag.toggleClass("tag-to-remove").toggleClass('btn-default').toggleClass('btn-danger');;
								tag.find(".fa").toggleClass("fa-times").toggleClass('fa-undo');
							});
						});
					})
					.fail(function() {
						console.log("error");
					})
					.always(function() {
						console.log("complete");
					});
					
				});
			})

		});
	</script>
	
</head>
<body>	

<div class="container">
	
	<div class="row">
		
		<div class="col-sm-12">
			<?php include('../includes/header.php'); ?>
			<ol class="breadcrumb">
				<li>
					<a href="/app/albums/<?php echo $albums_link_num ?>">Albums</a>
				</li>
				<li class="active"><?php echo $album["name"] ?></li>
			</ol>
		</div>
		
	</div>

	<section id="album-edit">
		<div class="row">
			<div class="col-sm-8">
				<?php

					foreach ($album["photos"] as $p) {
						?>
							<div class="col-sm-3">
								<div class="custom-thumb photo-thumb" data-photo-id="<?php echo $p["id"] ?>" style="background-image: url('<?php echo $p["thumb_url"] ?>')">
									<div class="album-thumb-inner">
										<!--span><?php echo $p["title"] ?></span-->
										<div class="thumb-marker bg-success"><i class="fa fa-check"></i></div>
									</div>
								</div>
							</div>
						<?php
					}
				?>
			</div>

			<div class="col-sm-4">
				
				<!--p>
					<button id="tool-select-all" class="btn btn-sm btn-success"><i class="fa fa-check-circle-o"></i>  Select All</button>
					<a href="" class="btn btn-sm btn-info"><i class="fa fa-picture-o"></i>  Open Album</a>

				</p-->

				<div class="well" id="tag-editor">
					<big><i class="fa fa-tags"></i> Remove Tags</big>
					
					<hr />
					
					<div id="tags"></div>

					<div class="row text-center hidden" id="tags-overlay-outer">
						<div class="col-sm-12">
							<div id="tags-overlay">
								<i class="fa fa-spin fa-refresh fa-3x"></i><br />Loading...
							</div>
						</div>
					</div>

					<div class="text-right">
						<button type="button" id="remove-submit" class="btn btn-danger btn-block">Remove selected tags</button>
					</div>

				</div>
			</div>
		</div>
	</section>

	<div class="row">
		<div class="col-sm-12">
			<div class="text-center">
				
				<?php include('../includes/footer.php'); ?>

			</div>
		</div>
	</div>
	
</div>

</body>
</html>