<?php
// start or resume current session
session_start();
// clear all the variables from the current session; otherwise, $_SESSION holds on to $_SESSION array value in the current script
// doesn't really matter in a script this short; just sounds like it's good practice to clear array before destroying the session
$_SESSION = [];
// destroy all data registered to the current session, which logs the user out
session_destroy();
// redirect user to homepage
header('Location: index.php');
// terminate script execution once user has been redirected
exit;
?>