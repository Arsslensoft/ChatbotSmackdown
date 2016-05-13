<?php
include "header.php";
	if($loggedin)
	{
		header("Location: profile.php");
		exit;
	}
	// Login from post data
	if( isset($_POST["username"]) &&  isset( $_POST["password"]))
	{

		// Attempt to login the user - if credentials are valid, it returns the users id, otherwise (bool)false.
		$res = $CBSDUM->loginUser($_POST["username"], $_POST["password"]);
		if(!$res)
			$error = "You supplied the wrong credentials.";
		else
		{
				header("Location: profile.php");
				exit;
		}

	} // Validation end


if($loggedin)
	include "header.loggedin.php";
else
	include "header.offline.php";
?>


<!-- Main Page -->
<div id="content" role="main">


	<!-- name page with background -->
	<section class="section swatch-black-beige" id="website_main_name">
		<div class="background-media skrollable skrollable-between" style="background-image: url(cbsm/background.jpg); background-size: cover; background-position: 50% 0px;" data-start="background-position: 50% 0px" data-top-bottom="background-position: 50% -200px">
		</div>
		<!--Background Overlay-->
		<div class="background-overlay" style="background-color:rgba(0, 0, 0, 0.2)">
		</div>
		<div class="container">
			<header class="section-header underline">

				<h1 style="font-family:'Agency FB'" class="headline hyper hairline" style="color : rgba(255, 255, 255, 0.7)">ChatBot SmackDown</h1>
			</header>
		</div>

	</section>


	<!-- login Section -->
	<section class="section swatch-beige-black has-top" id="login">
		<div class="decor-top">
			<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
				<path d="M0 0 L100 100 L0 100" stroke-width="0"></path>
			</svg>
		</div>

		<div class="container">
			<header class="section-header underline">
				<h1 class="headline super hairline">Login</h1>
			</header>


			<div class="text-center">
				<div class="panel panel-default">

					<div class="panel-body">
						<?php if( isset($error) ): ?>
							<p style="color: red">
								<?php echo $error; ?>
							</p>
						<?php endif; ?>

						<form accept-charset="UTF-8" method="post" action="login.php">

							<div class="form-group">
								<input class="form-control" placeholder="Username" name="username" type="text">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="password" type="password" value="">
							</div>

							<input class="btn btn-lg  btn-block" type="submit" value="Login">

						</form>
					</div>
				</div>
			</div>

		</div>

	</section>


	<footer class="section swatch-black-beige section-big-triangle" id="about" role="contentinfo">
		<div class="decor-top">
			<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
				<path d="M0 0 L50 100 L100 0 L100 100 L0 100" stroke-width="0"></path>
			</svg>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="sidebar-widget widget_categories">
						<h3 class="sidebar-header">Team members</h3>
						<ul>
							<li>
								<a href="#">
									Arsslen Idadi
								</a>
							</li>
							<li>
								<a href="#">
									Amine Troudi
								</a>
							</li>
							<li>
								<a href="#">
									Laouini Ahmed
								</a>
							</li>

						</ul>
					</div>
				</div>
				<div class="col-md-3">
					<div class="sidebar-widget widget_recent_entries">
						<h3 class="sidebar-header">Contact us</h3>
						<ul>
							<li>
								<div >
									<i class="fa fa-facebook">

									</i>
								</div>
								<a href="http://facebook.com/ChatBotsm">
									facebook.com/ChatBotsm
								</a>

							</li>
							<li>
								<div >
									<i class="fa fa-twitter"></i>
								</div>
								<a href="http://twitter.com/cbsm">
									twitter.com/cbsm
								</a>

							</li>
							<li>
								<div >
									<i class="fa fa-envelope"></i>
								</div>
								<a href="">
									INSAT- GL2
								</a>

							</li>
						</ul>
					</div>
				</div>
				<div class="col-md-3">
					<div class="sidebar-widget widget_recent_entries">
						<h3 class="sidebar-header">About Us</h3>
						<ul>
							<li>

								<a href="#">
									SDL Team 2016
								</a>

							</li>
							<li>

								<a href="#">
									ALL RIGHTS RESERVED
								</a>

							</li>

						</ul>
					</div>
				</div>


			</div>
		</div>
	</footer>
</div>
<a class="go-top hex-alt" href="javascript:void(0)">
	<i class="fa fa-angle-up"></i>
</a>
<script src="assets/js/packages.min.js"></script>
<script src="assets/js/theme.min.js"></script>
</body>
</html>
