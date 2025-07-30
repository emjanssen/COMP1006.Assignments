<?php

session_start();

// page metadata
$pageTitle = 'Register';
$pageDescription = "This is the registration page.";
$pageKeywords = 'register, signup';

// required files
require './templates/head.php';
require './templates/header.php';
require './inc/database.php';
require './inc/user.php';

/* - - - Run On Page Load - - - */

// check if user is logged in; if they are, print message about them already being logged in
if (isset($_SESSION['user_id'])) {
    // run footer code if user isn't logged in; otherwise, it doesn't show at all, because die() terminates the script early
    require './templates/footer.php';
    die("You are already logged in.");
}

// initialize variable for storing error message
$error = "";

/* - - -  Form Functions - - - */

// if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // if username was entered, retrieve form input values (with default fallback)
    if (isset($_POST['username'])) {
        // clean username with trim() to remove whitespace (and a few other specific characters)
        $username = trim($_POST['username']);
    } else {
        $username = '';
    }

    // if first name was entered, retrieve form input values (with default fallback)
    if (isset($_POST['first_name'])) {
        // clean first name with trim() to remove whitespace (and a few other specific characters)
        $firstName = trim($_POST['first_name']);
    } else {
        $firstName = '';
    }

    // if first name was entered, retrieve form input values (with default fallback)
    if (isset($_POST['last_name'])) {
        // clean last name with trim() to remove whitespace (and a few other specific characters)
        $lastName = trim($_POST['last_name']);
    } else {
        $lastName = '';
    }

    // if email was entered, retrieve form input values (with default fallback)
    if (isset($_POST['email_address'])) {
        // clean email with trim() to remove whitespace (and a few other specific characters)
        $email = trim($_POST['email_address']);
    } else {
        $email = '';
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
        // going to validate username and email here as well (after we created the user object, and can then use user class functions)
        $database = new Database();
        $databaseConnection = $database->getDatabaseConnection();

        // create a new User object, passing in our $databaseConnection value
        $user = new User($databaseConnection);


        // check if the username already exists in the database
        // if it already exists, we will assign an error message, jump down to else statement, and skip over registering user
        if (!empty($username)) {
            if ($user->userExists($username)) {
                // assign error message content if the message is already taken
                $error = "That username is already in use. Please choose a different username.";
            }
        }

        // check if the email already exists in the database
        // if it already exists, we will assign an error message, jump down to else statement, and skip over registering user
        if (!empty($email)) {
            if ($user->userEmailExists($email)) {
                // assign error message content if the message is already taken
                $error = "That email is already in use. Please choose a different email.";
            }
        }

        /* attempt to register the user
        we call registerUser() from our user class object, and pass in the username and password values
        if this works properly, we redirected user to login page, so they can log in with their newly created credentials
        we only execute this chunk of code if our $error variable still has the default variable we initialized it with at start of register.php; i.e. no errors have been identified
        */
        if ($error === "") {
            if ($user->registerUser($username, $firstName, $lastName, $email, $password)) {
                header('Location: login.php');
                exit;
            } else {
                // if registration fails, assign registration failure message value to $error
                // in-future, have more specific error message
                $error = "Registration failed.";
            }
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
                    <label for="first_name">First Name:</label><br>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                <br>
                <div>
                    <label for="last_name">Last Name:</label><br>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
                <br>
                <div>
                    <label for="email_address">Email Address:</label><br>
                    <input type="text" id="email_address" name="email_address" required>
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

<?php
require './templates/footer.php';
?>