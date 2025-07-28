<?php
// start session
session_start();

// page metadata
$pageTitle = 'Dashboard';
$pageDescription = "View all users here.";
$pageKeywords = 'profile, user, settings';

// include necessary templates and classes
require './templates/head.php';
require './templates/header.php';
require './inc/database.php';
require './inc/user.php';

// check if user is logged in; otherwise, deny access
if (!isset($_SESSION['user_id'])) {
    // run footer code if user isn't logged in; otherwise, it doesn't show at all, because die() terminates the script early
    require './templates/footer.php';
    die("Access denied. Please log in.");
}
?>

<main>
        <div id="main-dashboard">

        </div>
</main>

<?php
// run footer code here if the user was logged in properly when they loaded the page
require './templates/footer.php';
?>