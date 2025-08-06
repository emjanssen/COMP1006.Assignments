<?php
// - - - Start Session - - - //

session_start();

// - - - Page Metadata - - - //

$pageTitle = 'Register';
$pageDescription = 'User registration page.';
$pageKeywords = 'profile, registration, users, accounts';

// - - - Head and Header - - - //

require '../templates/head.php';
require '../templates/header.php';

// - - - Required Files - - - //

require '../inc/database.php';
require '../inc/user.php';

/* - - - Run On Page Load - - - */

// Validate Login Status //

// if user is not logged in, the code for this file stops executing here
if (isset($_SESSION['user_id'])) {
    require '../templates/footer.php';
    die("You are already logged in.");
}

/* - - - Form Functions - - - */

$error = "";

// Get User Inputs //

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate that all user inputs have been entered; if not, give the input a default value
    // Using ternary operator instead of full if/else statements
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $emailAddress = isset($_POST['email_address']) ? trim($_POST['email_address']) : '';
    $phoneNumber = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    // If password don't match, assign an error message.
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // If passwords match, create new Database() and User() objects.
        $database = new Database();
        $databaseConnection = $database->getDatabaseConnection();
        $user = new User($databaseConnection);

        // If username is not empty
        if (!empty($username)) {
            // If username already exists, assign error messages
            if ($user->userExists($username)) {
                $error = "That username is already in use. Please choose a different username.";
            }
        }
        // If email is not empty
        if (!empty($emailAddress)) {
            // Is email already exists, assign error message
            if ($user->emailExists($emailAddress)) {
                $error = "That email is already in use. Please choose a different email.";
            }
        }

        // If $error is still its default value, we have not encountered any registration errors, and we redirect user to login page
        if ($error === "") {
            if ($user->registerUser($username, $password, $firstName, $lastName, $emailAddress, $phoneNumber)) {
                header('Location: login.php');
                exit;
            }
            // If $error is anything but the default value, we assign $error a general registration failed message
            // In-future, would be good to have this function handle multiple error messages
            else {
                $error = "Registration failed.";
            }
        }
    }
}
?>
    <main class="global-main">

        <!-- if we have an error message value, echo the error message in red -->
        <?php if (!empty($error)) {echo '<p style="color: red;">' . htmlspecialchars($error) . '</p>';}?>

        <form method="POST" action="register.php">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div>
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div>
                <label for="email_address">Email Address:</label>
                <input type="email" id="email_address" name="email_address" required>
            </div>
            <div>
                <label for="phone_number">Phone number:</label>
                <input type="tel" id="phone_number" name="phone_number" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div>
                <button type="submit">Register</button>
            </div>
        </form>
    </main>
<?php

// - - - Footer - - - //

require '../templates/footer.php';
?>