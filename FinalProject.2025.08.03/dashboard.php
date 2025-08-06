<?php
// - - - Start Session - - - //

session_start();

// - - - Page Metadata - - - //

$pageTitle = 'Dashboard';
$pageDescription = 'Dashboard for all users.';
$pageKeywords = 'dashboard, users, accounts';

// - - - Head - - - //

require './templates/head.php';

// - - - Required Files - - - //
require './inc/database.php';
require './inc/user.php';

/* - - - Run On Page Load - - - */

// Validate user login; if user is not logged in, code stops executing here
if (!isset($_SESSION['user_id'])) {
    require './templates/header.php';
    require './templates/footer.php';
    die("Access denied. Please login.");
}

// Create Database() and User() objects
$database = new Database();
$databaseConnection = $database->getDatabaseConnection();
$user = new User($databaseConnection);

// Get user_id from the current session
$userId = $_SESSION['user_id'];
// Get current user using that user_id
$currentUser = $user->findUser($userId);

// Initialize error and success message variables
$success = '';
$error = '';

/* - - - Form Functions - - - */

?>

<!-- HTML Body -->

<body>

<div class="body-grid">

    <?php require './templates/header.php'; ?>

    <main class="global-main">

    </main>

    <?php require './templates/footer.php'; ?>

</div>
</body>
