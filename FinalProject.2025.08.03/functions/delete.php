<?php
// start session on load
session_start();

// - - - Required Files - - - //

require '../inc/database.php';
require '../inc/user.php';

/* - - - Run On Page Load - - - */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {

    if (!isset($_SESSION['user_id'])) {
        die("Access denied. You must be logged in to delete your account.");
    }

    $userId = $_SESSION['user_id'];
    $database = new Database();
    $user = new User($database->getDatabaseConnection());

    if ($user->deleteUser($userId)) {
        session_destroy();
        header("Location: ../login.php");
        exit;
    } else {
        // if deletion fails, display error
        echo "<p style='color: red;'>Account deletion failed.</p>";
    }
}
?>


