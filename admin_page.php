<?php
/*
 * UserCake Version: 2.0.2 http://usercake.com
 */
require_once ("models/config.php");
if (! securePage ( $_SERVER ['PHP_SELF'] )) {
	die ();
}
$pageId = $_GET ['id'];

// Check if selected pages exist
if (! pageIdExists ( $pageId )) {
	header ( "Location: admin_pages.php" );
	die ();
}

$pageDetails = fetchPageDetails ( $pageId ); // Fetch information specific to page
                                          
// Forms posted
if (! empty ( $_POST )) {
	$update = 0;
	
	if (! empty ( $_POST ['private'] )) {
		$private = $_POST ['private'];
	}
	
	// Toggle private page setting
	if (isset ( $private ) and $private == 'Yes') {
		if ($pageDetails ['private'] == 0) {
			if (updatePrivate ( $pageId, 1 )) {
				$successes [] = lang ( "PAGE_PRIVATE_TOGGLED", array (
						"private" 
				) );
			} else {
				$errors [] = lang ( "SQL_ERROR" );
			}
		}
	} elseif ($pageDetails ['private'] == 1) {
		if (updatePrivate ( $pageId, 0 )) {
			$successes [] = lang ( "PAGE_PRIVATE_TOGGLED", array (
					"public" 
			) );
		} else {
			$errors [] = lang ( "SQL_ERROR" );
		}
	}
	
	// Remove permission level(s) access to page
	if (! empty ( $_POST ['removePermission'] )) {
		$remove = $_POST ['removePermission'];
		if ($deletion_count = removePage ( $pageId, $remove )) {
			$successes [] = lang ( "PAGE_ACCESS_REMOVED", array (
					$deletion_count 
			) );
		} else {
			$errors [] = lang ( "SQL_ERROR" );
		}
	}
	
	// Add permission level(s) access to page
	if (! empty ( $_POST ['addPermission'] )) {
		$add = $_POST ['addPermission'];
		if ($addition_count = addPage ( $pageId, $add )) {
			$successes [] = lang ( "PAGE_ACCESS_ADDED", array (
					$addition_count 
			) );
		} else {
			$errors [] = lang ( "SQL_ERROR" );
		}
	}
	
	$pageDetails = fetchPageDetails ( $pageId );
}

$pagePermissions = fetchPagePermissions ( $pageId );
$permissionData = fetchAllPermissions ();

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
			<h2>Admin Page</h2>
			<div id='main'>
				<form name='adminPage'
					action='<?php echo $_SERVER['PHP_SELF']?>?id=<?php $pageId ?>'
					method='post'>
					<input class="form-control" type='hidden' name='process' value='1'>
					<table class='admin table'>
						<tr>
							<td>
								<h3>Page Information</h3>
								<div id='regbox'>

									<div class="form-group">
										<label class='control-label'>ID:</label>
<?php echo $pageDetails['id']?>
</div>
									<div class="form-group">
										<label class='control-label'>Name:</label>
<?php echo $pageDetails['page']?>
</div>
									<div class="form-group">
										<label class='control-label'>Private:</label>
<?php
// Display private checkbox
if ($pageDetails ['private'] == 1) {
	echo "<input type='checkbox' name='private' id='private' value='Yes' checked>";
} else {
	echo "<input  type='checkbox' name='private' id='private' value='Yes'>";
}

?>
</div>

								</div>
							</td>
							<td>
								<h3>Page Access</h3>
								<div id='regbox'>

									<div class="form-group">
										<label class='control-label'>Remove Access:</label>
<?php
// Display list of permission levels with access
foreach ( $permissionData as $v1 ) {
	if (isset ( $pagePermissions [$v1 ['id']] )) {
		echo "<br><input type='checkbox' name='removePermission[" . $v1 ['id'] . "]' id='removePermission[" . $v1 ['id'] . "]' value='" . $v1 ['id'] . "'> " . $v1 ['name'];
	}
}

?>
</div>
									<div class="form-group">
										<label>Add Access:</label>
<?php

// Display list of permission levels without access
foreach ( $permissionData as $v1 ) {
	if (! isset ( $pagePermissions [$v1 ['id']] )) {
		echo "<br><input type='checkbox' name='addPermission[" . $v1 ['id'] . "]' id='addPermission[" . $v1 ['id'] . "]' value='" . $v1 ['id'] . "'> " . $v1 ['name'];
	}
}

?>
</div>

								</div>
							</td>
						</tr>
					</table>
					<p>
						<label>&nbsp;</label> <input type='submit' value='Update'
							class='submit' />
					</p>
				</form>
			</div>
			<div id='bottom'></div>
		</div>

</body>
</html>
