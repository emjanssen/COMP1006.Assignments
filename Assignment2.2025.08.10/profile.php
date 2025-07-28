<?php
// start session
session_start();

// page metadata
$pageTitle = 'Your Profile';
$pageDescription = "Manage your account details here.";
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

// create database and user instances
$database = new Database();
$databaseConnection = $database->getDatabaseConnection();
$user = new User($databaseConnection);

// retrieve user ID from session
$userId = $_SESSION['user_id'];

// initialize message variables
$success = '';
$error = '';

// handle form submission to update username
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $newUsername = trim($_POST['username']);

    if (!empty($newUsername)) {
        // check if username already exists
        if ($user->userExists($newUsername)) {
            $error = "That username is already taken. Please choose a different one.";
        } else {
            // attempt to update username
            $updateSuccess = $user->updateUsername($userId, $newUsername);
            if ($updateSuccess) {
                $success = "Username updated successfully.";
                $_SESSION['username'] = $newUsername;
            } else {
                $error = "Failed to update username. Please try again.";
            }
        }
    } else {
        $error = "Username cannot be empty.";
    }
}

// fetch current user data
$currentUser = $user->findUser($userId);
?>

<main>
    <div id="main-profile">
        <h2>Your Profile</h2>

        <?php if (!empty($success)): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <?php if ($currentUser): ?>
            <form method="POST" action="profile.php">
                <div>
                    <label for="username">Username:</label><br>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($currentUser['username']); ?>" required>
                </div>
                <br>
                <div>
                    <button type="submit">Update Username</button>
                </div>
            </form>

        <?php else: ?>
            <p>User not found.</p>
        <?php endif; ?>
    </div>
</main>

<?php
// run footer code here if the user was logged in properly when they loaded the page
require './templates/footer.php';
?>