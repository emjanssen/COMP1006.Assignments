<?php

// start session on page load
session_start();

// page metadata
$pageTitle = 'Delete';
$pageDescription = "Delete user profile.";
$pageKeywords = 'profile, user, settings';

// required templates and classes
require './templates/head.php';
require './templates/header.php';
require './inc/database.php';
require './inc/user.php';

/* - - - Run On Page Load - - - */
?>
    <main>
        <?php

        // check that request method is post and user clicked button
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {

            // check that user is logged in
            if (!isset($_SESSION['user_id'])) {
                // run footer code here if we are denying access
                require './templates/footer.php';
                die("Access denied. You must be logged in to delete your account.");
            }

            // get user ID from session
            $userId = $_SESSION['user_id'];

            // create database and user instances
            $database = new Database();
            $user = new User($database->getDatabaseConnection());

            // attempt to delete user
            if ($user->deleteUser($userId)) {
                // if successful deletion, destroy the session and send the user back to login page
                session_destroy();
                header("Location: login.php");
                exit;
            } else {
                // if deletion fails, display error
                echo "<p style='color: red;'>Account deletion failed.</p>";
            }
        }
        ?>
    </main>

<?php
require './templates/footer.php';
?>