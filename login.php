<?php
/*
 * UserCake Version: 2.0.2 http://usercake.com
 */
require_once ("models/config.php");
if (! securePage ( $_SERVER ['PHP_SELF'] )) {
	die ();
}

// Prevent the user visiting the logged in page if he/she is already logged in
if (isUserLoggedIn ()) {
	header ( "Location: account.php" );
	die ();
}

// Forms posted
if (! empty ( $_POST )) {
	$errors = array ();
	$email = sanitize ( trim ( $_POST ["email"] ) );
	$password = trim ( $_POST ["password"] );
	
	// Perform some validation
	// Feel free to edit / change as required
	if ($email == "") {
		$errors [] = lang ( "ACCOUNT_SPECIFY_USERNAME" );
	}
	if ($password == "") {
		$errors [] = lang ( "ACCOUNT_SPECIFY_PASSWORD" );
	}
	
	if (count ( $errors ) == 0) {
		// A security note here, never tell the user which credential was incorrect
		if (! usernameExists ( $email )) {
			$errors [] = lang ( "ACCOUNT_USER_OR_PASS_INVALID" );
		} else {
			$userdetails = fetchUserDetails ( $email );
			// See if the user's account is activated
			if ($userdetails ["active"] == 0) {
				$errors [] = lang ( "ACCOUNT_INACTIVE" );
			} else {
				// Hash the password and use the salt from the database to compare the password.
				$entered_pass = generateHash ( $password, $userdetails ["password"] );
				
				if ($entered_pass != $userdetails ["password"]) {
					// Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
					$errors [] = lang ( "ACCOUNT_USER_OR_PASS_INVALID" );
				} else {
					// Passwords match! we're good to go'
					
					// Construct a new logged in user object
					// Transfer some db data to the session object
					$loggedInUser = new loggedInUser ();
					$loggedInUser->email = $userdetails ["email"];
					$loggedInUser->user_id = $userdetails ["id"];
					$loggedInUser->hash_pw = $userdetails ["password"];
					$loggedInUser->title = $userdetails ["title"];
					$loggedInUser->lastname = $userdetails ["lastname"];
					$loggedInUser->rut = $userdetails ["rut"];
					$loggedInUser->username = $userdetails ["user_name"];
					
					// Update last sign in
					$loggedInUser->updateLastSignIn ();
					$_SESSION ["userCakeUser"] = $loggedInUser;
					
					// Redirect to user account page
					header ( "Location: account.php" );
					die ();
				}
			}
		}
	}
}

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

?></div>
		<div class='jumbotron' id='content'>
			<h1><?php echo $websiteName; ?></h1>
			<h2>Ingreso</h2>

			<div id='main'>

				<div id='regbox'>
					<form name='login' action='<?php echo $_SERVER['PHP_SELF'] ?>'
						method='post'>
						<div class="form-group">
							<label class='control-label'>Correo:</label> <input class="form-control" type='text'
								name='email' />
						</div>
						<div class="form-group">
							<label class='control-label'>Password:</label> <input class="form-control"
								type='password' name='password' />
						</div>
						<div class="form-group">
							<label class='control-label'>&nbsp;</label> <input type='submit'
								value='Login' class='submit' />
						</div>

					</form>
				</div>
			</div>
			<div id='bottom'></div>
		</div>

</body>
</html>
