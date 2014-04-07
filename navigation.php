<?php
/*
 * UserCake Version: 2.0.2 http://usercake.com
 */
if (! securePage ( $_SERVER ['PHP_SELF'] )) {
	die ();
}
?>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse"
				data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#"><?php echo $websiteName; ?></a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
<?php
// Links for logged in user
if (isUserLoggedIn ()) {
	?>
				
				<li class="active"><a href="account.php">Home</a></li>
				<li class="dropdown"><a href="#" class="dropdown-toggle"
					data-toggle="dropdown">User <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="account.php">User</a></li>
						<li><a href="user_settings.php">Configuración</a></li>
						<li><a href='logout.php'>Logout</a></li>
<?php
	// Links for permission level 2 (default admin)
	if ($loggedInUser->checkPermission ( array (
			2 
	) )) {
		?>
						<li class="divider"></li>
						<li class="dropdown-header">Admin</li>
						<li><a href="#">Admin Configuration</a></li>
						<li><a href="#">Admin Users</a></li>
						<li><a href="#">Admin Permissions</a></li>
					</ul></li>


<?php
	}
} // Links for users not logged in
else {
	?>

				<li class="active"><a href='index.php'>Home</a></li>
				<li><a href='login.php'>Login</a></li>
				<li><a href='register.php'>Register</a></li>
				<li><a href='forgot-password.php'>Forgot Password</a></li>
<?php
	if ($emailActivation) {
		echo "<li><a href='resend-activation.php'>Resend Activation Email</a></li>";
	}
	echo "</ul>";
}

?>

		
		
		
		
		
		</div>
		<!--/.nav-collapse -->
	</div>
</div>