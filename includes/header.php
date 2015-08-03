<?php 
	

	if (!isset($_SESSION["phpFlickr_auth_token"]) || empty($_SESSION["phpFlickr_auth_token"])) {
		?>
			<script>
				window.location = "/";
			</script>
		<?php
	}

	else {
		$test = $f->test_login();
		$me = $f->people_getInfo($test["id"]);
		$name = $me["realname"]["_content"];
	}

?>

<div class="row">
	<div class="col-sm-12">
	
		<h1 class="page-header">
			TagIt for Flickr

			

			<div class="btn-group pull-right">
				<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $name ?> <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="/logout.php">Logout</a></li>
				</ul>
			</div>



		</h1>
		
	</div>
</div>