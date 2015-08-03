<?php 
	session_start();

	require_once('../php/api_settings.php');
	require_once('../php/api_auth.php');

	require_once('../php/get_albums.php');

	$album_page = (isset($_GET["album_page"])? $_GET["album_page"] : 1);
	$_SESSION["last_album_page"] = $album_page;

?>

<!doctype html>
<html>
<head>
	
	<title>TagIt | Bulk Flickr Tag Editor</title>
	
	<?php include("../includes/assets.php") ?>
	
	<!--script src="js/main.js"></script-->

	<script type="text/javascript">
		$(document).ready(function() {
			$(".album-thumb").click(function(){
				console.log("clique: " +$(this).data('album-id'));
				window.location = "/app/edit/" + $(this).data('album-id');
			});
			$("#album-jump").submit(function(event) {
				event.preventDefault();
				var value = $("#album-jump input").val();
				var isnum = /^\d+$/.test(value);

				if (isnum) {
					window.location = "/app/edit/" + value;
				}
				else {
					$("#album-jump .form-group").addClass("has-error");
				}
			});
		});
	</script>
	
</head>
<body>	

<div class="container">
	
	<div class="row">
		
		<div class="col-sm-12">
			<?php include('../includes/header.php'); ?>
			<ol class="breadcrumb">
				<li class="active">Albums</li>
			</ol>
			<!--p class="text-info">
			Select an album to continue...
			</p-->
		</div>
		
	</div>

	<section id="album-select">


		<?php
			if (count($albums["albums"]) == 0) {
				?>
				<div class="row">
					<div class="col-sm-6">
						<div class="alert alert-info">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<strong>Sorry!</strong> Tagga currently only supports editing albums. Sort your gallery into a few albums and try again.
						</div>
					</div>
				</div>
				<?php
			}
			else {
				?>
					<div class="row">
						<div class="col-sm-8">
							<?php

								foreach($albums["albums"] as $a) {
									?> 
										<div class="col-sm-3">
											<div class="custom-thumb album-thumb" data-album-id="<?php echo $a["id"] ?>" style="background-image: url('<?php echo $a["thumb_url"] ?>')">
												<div class="album-thumb-inner">
													<span><?php echo $a["title"]["_content"] ?></span>
												</div>
											</div>
										</div>
									<?php
								}
							?>
						</div>
						<div class="col-sm-4">
							<div class="well">
								<div class="row" id="pagination">
									<div class="col-sm-3 text-left">
										<a id="pagination-prev" class="btn btn-info <?php echo ($album_page == 1?"disabled":"") ?>" href="/app/albums/<?php echo $album_page-1?>"><i class="fa fa-arrow-left"></i></a>
									</div>
									<div class="col-sm-6 text-center" id="pagination-text">Page <?php echo $album_page ?> of <?php echo $albums["pages"] ?></div>
									<div class="col-sm-3 text-right">
										<a id="pagination-next" class="btn btn-info <?php echo ($album_page == $albums["pages"]?"disabled":"") ?>" href="/app/albums/<?php echo $album_page+1?>"><i class="fa fa-arrow-right"></i></a>
									</div>
								</div>

								<hr />
								
								<form id="album-jump">
									<div class="form-group">
										<label class="control-label">Jump to Album</label>
										<div class="input-group">
											<input type="text" placeholder="Album ID" class="form-control" value="">
											<span class="input-group-btn" id="album-id-input">
												<button type="submit" class="btn btn-success">Go</button>
											</span>
										</div>
									</div>
								</form>

								

							</div>

							<div class="well">
								<strong>App going slow?</strong>
								<p>
									<a href="/app/setup">Click here</a> to run the setup process again. This may need to be done periodically.
								</p>

							</div>

						</div>
					</div>
				<?php
			}

		?>

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