<?php
// start session on load
session_start();

// - - - Required Files - - - //
require '../inc/database.php';
require '../inc/user.php';

/* - - - Run On Page Load - - - */

// if form is submitted and contains 'delete_user'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    // get user id from the form
    $userIdToDelete = $_POST['delete_user'];

    // get current session user ID
    $currentUserId = $_SESSION['user_id'] ?? null;

    // create new database and user objects
    $database = new Database();
    $user = new User($database->getDatabaseConnection());

    if ($user->deleteUser($userIdToDelete)) {
        // if deleted user is current user, log them out
        if ($currentUserId == $userIdToDelete) {
            session_destroy();
            header("Location: ../login.php");
            exit;
        }

        // otherwise, send them back to dashboard
        header("Location: ../dashboard.php");
        exit;
    } else {
        echo "<p style='color: red;'>User deletion failed.</p>";
    }
}
?>
