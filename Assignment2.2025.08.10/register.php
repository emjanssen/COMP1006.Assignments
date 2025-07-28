<?php
// page metadata
$pageTitle = 'Register';
$pageDescription = "This is the registration page.";
$pageKeywords = 'register, signup';

// required files
require './templates/head.php';
require './templates/header.php';
require './templates/footer.php';
require './inc/database.php';
require './inc/user.php';

// initialize variable for storing error message
$error = "";

// if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // if username was entered, retrieve form input values (with default fallback)
    if (isset($_POST['username'])) {
        // clean username with trim() to remove whitespace (and a few other specific characters)
        $username = trim($_POST['username']);
    } else {
        $username = '';
    }

    // if password was entered, retrieve form input values (with default fallback)
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = '';
    }

    // ask for password entry a second time; if $confirmPassword is entered, retrieve form input values (with default fallback)
    if (isset($_POST['confirmPassword'])) {
        $confirmPassword = $_POST['confirmPassword'];
    } else {
        $confirmPassword = '';
    }

    // check if password and confirmPassword match
    // if they don't match, we will go down to else section, and assign $error message that registration failed
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // if password and confirmPassword do match, create a new database object, call getDatabaseConnection() on that object, and assign outcome to $databaseConnection
        $database = new Database();
        $databaseConnection = $database->getDatabaseConnection();

        // create a new User object, passing in our $databaseConnection value
        $user = new User($databaseConnection);

        /* attempt to register the user
        we call registerUser() from our user class object, and pass in the username and password values
        if this works properly, we redirected user to login page, so they can log in with their newly created credentials
        */
        if ($user->registerUser($username, $password)) {
            header('Location: login.php');
            exit;
        } else {
            // if registration fails, assign registration failure message value to $error
            $error = "Registration failed. Username may already exist.";
        }
    }
}
?>

<main>
    <!-- registration form is basically the same set-up/process as form in login.php; not going to comment everything again -->

    <?php
    if (!empty($error)) {
        echo '<p style="color: red;">' . htmlspecialchars($error) . '</p>';
    }
    ?>

    <div id="main-register">
        <h2>Please create an account.</h2>

        <!-- registration form -->
        <form method="POST" action="register.php">

            <div>
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" required>
            </div>
            <br>
            <div>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required>
            </div>
            <br>
            <div>
                <label for="confirmPassword">Confirm Password:</label><br>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>
            <br>
            <div>
                <button type="submit">Register</button>
            </div>
        </form>
    </div>
</main>