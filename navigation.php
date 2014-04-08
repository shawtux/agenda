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
			<ul class="nav navbar-nav pull-right">
<?php
// Links for logged in user
if (isUserLoggedIn ()) {
	?>
				
				<li class="active"><a href="account.php">Home</a></li>
				<li class="dropdown"><a href="#" class="dropdown-toggle"
					data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span><?php echo $loggedInUser->username." ".$loggedInUser->lastname ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="account.php">Usuario</a></li>
						<li><a href="user_settings.php">Configuración</a></li>
						
<?php
	// Links for permission level 2 (default admin)
	
	if ($loggedInUser->checkPermission ( array (
			2 
	) )) {
		?>
						<li class="divider"></li>
						<li><a href='admin_configuration.php'>Admin Configuration</a></li>
						<li><a href='admin_users.php'>Admin Users</a></li>
						<li><a href='admin_permissions.php'>Admin Permissions</a></li>
						<li><a href='admin_pages.php'>Admin Pages</a></li>
					


<?php
	}
	?>
						<li class="divider"></li>
						<li><a href='logout.php'>Logout</a></li>
						</ul></li>
<?php 	
} // Links for users not logged in
else {
	?>

				<li class="active"><a href='index.php'>Home</a></li>
				<li><a href='login.php'>Identificarse</a></li>
				<li><a href='register.php'>Registrarse</a></li>
				<li><a href='forgot-password.php'>Recuperar contraseña</a></li>
<?php
	//if ($emailActivation) {
	//	echo "<li><a href='resend-activation.php'>Resend Activation Email</a></li>";
	//}
	
}

?>
</ul>
		
		
		
		
		
		
		
		</div>
		<!--/.nav-collapse -->
	</div>
</div>