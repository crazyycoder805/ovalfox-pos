<!DOCTYPE html>

<html lang="zxx">

<?php 
require_once 'assets/includes/head.php';
?>
<body>
	<div class="loader">
	  <div class="spinner">
		<img src="assets/images/loader.gif" alt=""/>
	  </div> 
	</div>
    <!-- Main Body -->
    <div class="fb-main-404section">
		<div class="fb-404page">
			<img src="assets/images/error.png" alt="">
			<h1>Oops... Page Not Found</h1>
			<p>Do not Worry Back To Previous Pages</p>
			<div class="fb-404btn">
				<a href="index-2.html" class="ad-btn">back to home</a>
			</div>
		</div>
	</div>
	<!-- Color Setting -->
	<div id="style-switcher">
		<div>
			<ul class="colors">
				<li>
					<p class='colorchange' id='color'>
					</p>
				</li>
				<li>
					<p class='colorchange' id='color2'>
					</p>
				</li>
				<li>
					<p class='colorchange' id='color3'>
					</p>
				</li>
				<li>
					<p class='colorchange' id='color4'>
					</p>
				</li>
				<li>
					<p class='colorchange' id='color5'>
					</p>
				</li>
				<li>
					<p class='colorchange' id='style'>
					</p>
				</li>
			</ul>
		</div>
		<div class="bottom">
			<a href="#" class="settings">
				<i class="fa fa-cog" aria-hidden="true"></i>
			</a>
		</div>
	</div>
   <?php require_once 'assets/includes/javascript.php'; ?>
</body>


</html>