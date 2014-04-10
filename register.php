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
	$email = trim ( $_POST ["email"] );
	$username = trim ( $_POST ["username"] );
	$userlastname = trim ( $_POST ["userlastname"] );
	$userrut = trim ( $_POST ["rut"] );
	$password = trim ( $_POST ["password"] );
	$confirm_pass = trim ( $_POST ["passwordc"] );
	$captcha = md5 ( $_POST ["captcha"] );
	
	if ($captcha != $_SESSION ['captcha']) {
		$errors [] = lang ( "CAPTCHA_FAIL" );
	}
	if (minMaxRange ( 5, 25, $username )) {
		$errors [] = lang ( "ACCOUNT_USER_CHAR_LIMIT", array (
				5,
				25 
		) );
	}
	if (! ctype_alnum ( $username )) {
		$errors [] = lang ( "ACCOUNT_USER_INVALID_CHARACTERS" );
	}
	if (minMaxRange ( 5, 25, $userlastname )) {
		$errors [] = lang ( "ACCOUNT_DISPLAY_CHAR_LIMIT", array (
				5,
				25 
		) );
	}
	if (! ctype_alnum ( $userlastname )) {
		$errors [] = lang ( "ACCOUNT_DISPLAY_INVALID_CHARACTERS" );
	}
	if (minMaxRange ( 6, 50, $password ) && minMaxRange ( 6, 50, $confirm_pass )) {
		$errors [] = lang ( "ACCOUNT_PASS_CHAR_LIMIT", array (
				6,
				50 
		) );
	} else if ($password != $confirm_pass) {
		$errors [] = lang ( "ACCOUNT_PASS_MISMATCH" );
	}
	if (! isValidEmail ( $email )) {
		$errors [] = lang ( "ACCOUNT_INVALID_EMAIL" );
	}
	if (minMaxRange ( 10, 14, $userrut )) {
		$errors [] = lang ( "RUT_LENGTH_INVALID" );
	}
	if (! validaRut ( $userrut )) {
		$errors [] = lang ( "RUT_FORMAT_WRONG" );
	}
	
	// End data validation
	if (count ( $errors ) == 0) {
		// Construct a user object
		$user = new User ( $username, $userlastname, $userrut, $password, $email );
		
		// Checking this flag tells us whether there were any errors such as possible data duplication occured
		if (! $user->status) {
			if ($user->username_taken)
				$errors [] = lang ( "ACCOUNT_USERNAME_IN_USE", array (
						$username 
				) );
			if ($user->email_taken)
				$errors [] = lang ( "ACCOUNT_EMAIL_IN_USE", array (
						$email 
				) );
			if ($user->rut_taken)
				$errors [] = lang ( "ACCOUNT_RUT_IN_USE", array (
						$rut
				));
		} else {
			// Attempt to add the user to the database, carry out finishing tasks like emailing the user (if required)
			if (! $user->userCakeAddUser ()) {
				if ($user->mail_failure)
					$errors [] = lang ( "MAIL_ERROR" );
				if ($user->sql_failure)
					$errors [] = lang ( "SQL_ERROR" );
			}
		}
	}
	if (count ( $errors ) == 0) {
		$successes [] = $user->success;
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
?>
</div>
		<div  id='content'>
			<h1><?php echo $websiteName; ?></h1>
			<h2>Nuevo Registro</h2>
			<div id='main'>

				<div id='regbox'>
					<form name='newUser' action='<?php $_SERVER['PHP_SELF'] ?>'
						method='post' class="form-horizontal">


						<div class="form-group">
							<label class='control-label col-sm-2'>Nombre:</label>
							<div class="col-sm-10">
								<input class="form-control" type='text' name='username' />
							</div>
						</div>
						<div class="form-group">
							<label class='control-label col-sm-2'>Apellido:</label>
							<div class="col-sm-10">
								<input class="form-control" type='text' name='userlastname' />
							</div>
						</div>
						<div class="form-group">
							<label class='control-label col-sm-2'>Constraseña:</label>
							<div class="col-sm-10">
								<input class="form-control" type='password' name='password' />
							</div>
						</div>
						<div class="form-group">
							<label class='control-label col-sm-2'>Confirmar contraseña:</label>
							<div class="col-sm-10">
								<input class="form-control" type='password' name='passwordc' />
							</div>
						</div>
						<div class="form-group">
							<label class='control-label col-sm-2'>Email:</label>
							<div class="col-sm-10">
								<input class="form-control" type='text' name='email' />
							</div>
						</div>
						<div class="form-group">
							<label class='control-label col-sm-2'>Rut:</label>
							<div class="col-sm-10">
								<input class="form-control" type='text' name='rut' />
							</div>
						</div>
						<div class="form-group">
							<label class='control-label col-sm-2'>Codigo de seguridad:</label>
							<div class="col-sm-10">
								<img src='models/captcha.php'>
							</div>
						</div>
						<div class="form-group">
							<label class='control-label col-sm-2'>Ingresar codigo:</label>
							<div class="col-sm-10">
								<input class="form-control" name='captcha' type='text'>
							</div>
						</div>
						<label>&nbsp;<br> <input type='submit' value='Registarse' />
					
					</form>
				</div>

			</div>
			<div id='bottom'></div>
		</div>

</body>
</html>
