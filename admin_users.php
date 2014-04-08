<?php
/*
 * UserCake Version: 2.0.2 http://usercake.com
 */
require_once ("models/config.php");

if (! securePage ( $_SERVER ['PHP_SELF'] )) {
	die ();
}

// Forms posted
if (! empty ( $_POST )) {
	$deletions = $_POST ['delete'];
	if ($deletion_count = deleteUsers ( $deletions )) {
		$successes [] = lang ( "ACCOUNT_DELETIONS_SUCCESSFUL", array (
				$deletion_count 
		) );
	} else {
		$errors [] = lang ( "SQL_ERROR" );
	}
}

$userData = fetchAllUsers (); // Fetch information for all users

require_once ("models/header.php");
?>
<body>
	<div class='container' id='wrapper'>
<?php
require_once ("navigation.php");
?>
<div id='top'>
<?php
echo resultBlock ( $errors, $successes );
?>
</div>
		<div class='jumbotron' id='content'>
			<h1><?php echo $websiteName; ?></h1>
			<h2>Admin Users</h2>

			<div id='main'>
				<form name='adminUsers' action='<?php echo $_SERVER['PHP_SELF']?>'
					method='post' class="form-horizontal" role="form">
					<table class='admin table table-hover table-condensed'>
						<tr>
							<th>Delete</th>
							<th>Name</th>
							<th>Rut</th>
							<th>Email</th>
							<th>Title</th>
							<th>Last Sign In</th>
						</tr>
						<?php
						// Cycle through users
						foreach ( $userData as $v1 ) {
							?>
						<tr>
							<td><div class="checkbox">
									<input type='checkbox' name='delete[<?php echo $v1['id'] ?>]'
										id='delete[<?php echo $v1 ['id']?>]'
										value='<?php echo $v1['id'] ?>'>
								</div></td>
							<td><a href='admin_user.php?id=<?php echo $v1['id'] ?>'><?php echo $v1['user_name']." ".$v1['lastname']?></a></td>
							<td><?php echo $v1['rut'] ?></td>
							<td><?php echo $v1['email'] ?></td>
							<td><?php echo $v1['title'] ?></td>
							<td> 
							<?php
							// Interprety last login
							if ($v1 ['last_sign_in_stamp'] == '0') {
								echo "Never";
							} else {
								echo date ( "j M, Y", $v1 ['last_sign_in_stamp'] );
							}
							?>
								</td>
						</tr>
						<?php
						}
						?>
					</table>
					<input class="form-control" type='submit' name='Submit'
						value='Delete' />
				</form>
			</div>
			<div id='bottom'></div>
		</div>

</body>
</html>

