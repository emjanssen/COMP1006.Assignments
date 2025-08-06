<?php
/* - - - Begin Session - - - */

session_start();

/* - - - Page Metadata - - - */

$pageTitle = 'Login';
$pageDescription = "This is the login page.";
$pageKeywords = 'home, landing page';

/* - - - Required Files - - - */

require '../templates/head.php';
require '../templates/header.php';
require '../inc/database.php';
require '../inc/user.php';

/* - - - Run On Page Load - - - */

// check if user is logged in; if they are, print message about them already being logged in
if (isset($_SESSION['user_id'])) {
    // run footer code if user isn't logged in; otherwise, it doesn't show at all, because die() terminates the script early
    require '../templates/footer.php';
    die("You are already logged in.");
}

// initialize variable for storing error message
$error = "";

/* - - - Form Functions - - - */

// verify whether form was submitted using the post method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // if form was submitted using post, we create a new database connection
    $database = new Database();
    $databaseConnection = $database->getDatabaseConnection();

    // create a new User object via our User class
    $user = new User($databaseConnection);

    // retrieve form input values (with fallback in case fields are missing)
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
    } else {
        $username = '';
    }

    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = '';
    }

    // pass the username and password values to our loginUser() function
    $loginResult = $user->loginUser($username, $password);

    // if the login is successful; i.e. $loginResult contains user data (not false)
    // note to self: $loginResult isn't a boolean true; it's either an associative array with user data, or it's false
    if ($loginResult) {
        // we store the user info (i.e. username and user id) in the current session
        // we know the id because it's part of our $loginResult value
        $_SESSION['user_id'] = $loginResult['id'];
        $_SESSION['username'] = $loginResult['username'];

        // and we redirect the user to their user profile
        header('Location: profile.php');
        exit;

    } else {
        // if the login fails, assign the error message string to our error variable
        $error = "Invalid username or password.";
    }
}
?>

<main>

    <div class="global-main">
        <h2>Please log in.</h2>

        <?php
        // if our error message value is not empty
        if (!empty($error)) {
            // we use echo to print an error message
            echo '<p style="color: red;">' . htmlspecialchars($error) . '</p>';
        }
        ?>

        <!-- login form; action calls our login.php file; i.e. the code defined above -->
        <form method="POST" action="login.php" name="login-form">
            <!-- fields for username and password; both are required -->
            <div>
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</main>

<?php
require '../templates/footer.php';
?>
