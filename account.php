<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
require_once ("navigation.php");
?>
<body>
<div id='wrapper'>
<div id='top'><div id='logo'></div></div>
<div id='content'>
<h1>UserCake</h1>
<h2>Account</h2>
<div id='left-nav'>
<?php 
include("left-nav.php");
?>

</div>
<div id='main'>
Hey, <?php echo $loggedInUser->username ?> This is an example secure page designed to demonstrate some of the basic features of UserCake. Just so you know, your title at the moment is <?php echo $loggedInUser->title ?>, and that can be changed in the admin panel. You registered this account on "<?php echo date("M d, Y", $loggedInUser->signupTimeStamp()) ?>".
</div>
<div id='bottom'></div>
</div>
</body>
</html>