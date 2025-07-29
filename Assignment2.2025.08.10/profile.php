<?php

// Note: leaving detailed comments in because I find them useful for learning; would remove them from real life production code

// start session on page load
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

/* - - - Run On Page Load - - - */

// check if user is logged in; otherwise, deny access
if (!isset($_SESSION['user_id'])) {
    // run footer code if user isn't logged in; otherwise, it doesn't show at all, because die() terminates the script early
    require './templates/footer.php';
    die("Access denied. Please log in.");
}

/* - If we make it to this part of the run-on-page-load code, it's because the user is logged in. - */

/* Why we still create a new database and user object, even though these objects were created during login.php code:

- HTTP is stateless, and PHP is per-request
- when login.php finishes executing and sends a redirect, everything in memory is gone; all variables are wiped (not just the objects, but everything)
- so even though we created Database and User objects in login.php, PHP won't persist object instances between page loads
- i.e. each page (example: profile.php) must recreate these objects

1. When we log in, these values are saved: $_SESSION['user_id'] = $loginResult['id'] and $_SESSION['username'] = $loginResult['username']
these values are saved on the server, and linked to the user's session cookie
even after login.php script finishes, these session values persist as long as the session is active (until we close the browser, or logout, or the session expires, etc.)
so we have access to $_SESSION['user_id'] and $_SESSION['username'] even though login.php has finished executing its code

2. When we redirect user to dashboard.php upon successful login:
    // first we start the same session again/resume the existing session
    session_start();

    // $_SESSION is populated from the session file (which is likely stored on the server, and would be tied to the user's session ID)
    // if a user id hasn't already been set, then the page dies/profile.php script terminates
    if (!isset($_SESSION['user_id'])) {
    die("Access denied");
    }

3. We recreate Database and User objects in dashboard.php:
    $database = new Database();
    $databaseConnection = $database->getDatabaseConnection();
    $user = new User($databaseConnection);

    even though they are new instances, they'll still have access to the same user data from the session, i.e. data entered during login */

// create database instance
$database = new Database();
$databaseConnection = $database->getDatabaseConnection();
$user = new User($databaseConnection);

// retrieve user ID from session
$userId = $_SESSION['user_id'];

// initialize message variables
$success = '';
$error = '';

// fetch current user data
// will use this value further down in form
$currentUser = $user->findUser($userId);

/* - - - Form Functions - - - */

// form submission to update username
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $newUsername = trim($_POST['username']);

    // if input for $newUsername isn't empty
    if (!empty($newUsername)) {
        // and if the $newUsername doesn't already belong to an existing user (checking that via userExists() from our user object)
        if ($user->userExists($newUsername)) {
            // assign error message content if the message is already taken
            $error = "That username is already taken. Please choose a different one.";
        } else {
            // if $newUsername doesn't exist already, attempt to update username
            // we called the updateUsername() function from our user class, and pass in the current user id, along with the updated username data
            // assign the result to $updateSuccess
            $updateSuccess = $user->updateUsername($userId, $newUsername);
            // if the update is successful
            if ($updateSuccess) {
                // assign a success message
                $success = "Username updated successfully.";
                // update current $_SESSION value for username to the new username
                $_SESSION['username'] = $newUsername;
            } // if username was not updated successfully, assign an error message
            else {
                $error = "Failed to update username. Please try again.";
            }
        }
    } // if $newUsername is empty, assign an error message value
    else {
        $error = "Username cannot be empty.";
    }
}
?>

    <main>
        <div id="main-profile">
            <h2>Your Profile</h2>

            <!-- if our success variable isn't empty -->
            <?php if (!empty($success)): ?>

                <!-- echo out our success message -->
                <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <!-- if our error variable isn't empty -->
            <?php if (!empty($error)): ?>
                <!-- echo out our error message -->
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <!-- checks if we have a $currentUser value; we called findUser() upon page load
             if findUser() returned a valid user record, we'll have an array with id and username
             if it didn't return a valid record, $currentUser will have a value of false or null
             -->
            <?php if ($currentUser): ?>
                <!-- form action linked to profile.php code -->
                <form method="POST" action="profile.php">
                    <div>
                        <label for="username">Username:</label><br>
                        <input type="text" id="username" name="username"
                        <!-- the value of $currentUser will be echoed into form here -->
                        value="<?php echo htmlspecialchars($currentUser['username']); ?>" required>
                    </div>
                    <br>
                    <div>
                        <button type="submit">Update Username</button>
                    </div>
                </form>

                <!-- if $currentUser is false/null, we echo a user not found message -->
            <?php else: ?>
                <p>User not found.</p>
            <?php endif; ?>
        </div>
    </main>

<?php
// run footer code here if the user was logged in properly when they loaded the page
require './templates/footer.php';
?>