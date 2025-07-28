<?php
// page metadata
$pageTitle = 'Your Profile';
$pageDescription = "Manage your account details here.";
$pageKeywords = 'profile, user, settings';

// include necessary templates and classes
require './templates/head.php';
require './templates/header.php';
require './inc/database.php';
require './inc/user.php';

// start session
session_start();

// check if user is logged in; otherwise, deny access
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}
?>

<main>
        <div id="main-dashboard">

        </div>
</main>

<?php
require './templates/footer.php';
?>