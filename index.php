<?php 
	session_start();

	require_once('php/api_settings.php');
?>

<!doctype html>
<html>
<head>
	
	<title>TagIt | Bulk Flickr Tag Editor</title>
	
	<?php include("includes/assets.php") ?>
	
	<script src="js/main.js"></script>
	
</head>
<body>	

<div class="container">

	<div class="row">

		<div class="col-sm-6 col-sm-offset-3">
			<br />
			<div class="well">

				<h1 class="text-center">TagIt for Flickr</h1>
				<hr />
				
				

				<?php 

					if (!isset($_SESSION["phpFlickr_auth_token"]) || empty($_SESSION["phpFlickr_auth_token"])) {
						$api_perms = "write";
						$api_sig = $api_secret . "api_key" . $api_key . "perms" . $api_perms;
						$api_sig = md5($api_sig);
						$url = "http://flickr.com/services/auth/?api_key=" . $api_key . "&perms=". $api_perms ."&api_sig=" . $api_sig;
						?>
							<a href="<?php echo $url ?>" class="btn btn-block btn-info"><i class="fa fa-flickr"></i> Login with Flickr</a> 
						<?php
					}

					else {

						?>
							Thank you for logging in... <br />
							Redirecting you to the application.
							<script>
								window.location = "app";
							</script>
						<?php
					}

				?>

			</div>
		</div>

	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="text-center">
				
				<?php include('includes/footer.php'); ?>

			</div>
		</div>
	</div>
	
</div>

</body>
</html>