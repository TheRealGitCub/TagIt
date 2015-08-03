<?php 
	session_start();

	require_once('../../php/api_settings.php');
	require_once('../../php/api_auth.php');
?>

<!doctype html>
<html>
<head>
	
	<title>TagIt | Bulk Flickr Tag Editor</title>
	
	<?php include("../../includes/assets.php") ?>

	<script>

	var albumPage = 1;

	function cacheAlbums(page) {

		console.log("caching page " + page);

		$.ajax({
			url: '/php/cache_album.php',
			type: 'GET',
			dataType: 'json',
			data: {album_page: albumPage},
		})
		.done(function(data) {
			console.log("success pages:" + data.pages);

			$("#progress .progress-bar").css('width', (albumPage / data.pages)*100 + "%" );

			albumPage++;

			if (albumPage <= data.pages) {
				cacheAlbums(albumPage);
			}
			else {
				window.location = "/app/albums/1";
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	}

	cacheAlbums(1);

	</script>
	
</head>
<body>	

<div class="container">
	
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
		<br />
			<div class="well">
				
			<h1 class="text-center">TagIt for Flickr</h1>
			<hr />

				<div class="row">
					
					<div class="col-sm-4 text-center">
						<i class="fa fa-spinner fa-pulse" id="setup-icon"></i>
						<div class="small" id="progress-status">Saving albums to cache...</div>
					</div>
					<div class="col-sm-8">
						<h2>Hang tight!</h2>
						<p>
							We're pre-loading all of your albums to ensure speedy load times. You can technically <a href="/app/albums/1">skip this step</a>, but the Flickr API is really slow so I don't recommend it. Go grab a coffee and a snack!
						</p>
					</div>

				</div>


				<div class="progress" id="progress">
					<div class="progress-bar progress-bar-success" style="width: 0%;"></div>
				</div>

			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="text-center">
				
				<?php include('../../includes/footer.php'); ?>

			</div>
		</div>
	</div>
	
</div>

</body>
</html>