<?php /** @noinspection ALL */

// use built-in function to begin session so we can manage login state
session_start();

// page metadata
$pageTitle = 'Login';
$pageDescription = "This is the login page.";
$pageKeywords = 'home, landing page';

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

/* - - - Form Functions - - - */

// verify whether form was submitted using the post method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* if it was submitted using post (i.e. the form was submitted), we create a new database connection (via our Database class)
    first create the database object, and then call getDatabaseConnection on that object, and assign value to $databaseConnection */
    $database = new Database();
    $databaseConnection = $database->getDatabaseConnection();

    // create a new User object via our User class; we pass in the $databaseConnection that we just established, and assign value to user variable
    $user = new User($databaseConnection);

    /* retrieve form input values (with fallback in case fields are missing)
    if the user submits a username value, we assign their input to $username
    otherwise, we just give $username a value of ''
    */
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
    } else {
        $username = '';
    }

    /* same process for password as for username */
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = '';
    }

    /* pass the username and password values to our loginUser() function, which we call on our user object; assign outcome to $loginResult
    based on how we've written loginUser()
    fetch(PDO::FETCH_ASSOC) returns a single row as an associative array; in other words, the column names become array keys
        $loginResult = [
            'id' => some id number,
            'username' => 'some username',
            'password' => 'hashed password value'
        ];
    fetch(PDO::FETCH_ASSOC) returns false value in case of failed login
    */
    $loginResult = $user->loginUser($username, $password);

    // if the login is successful; i.e. $loginResult contains user data (not false)
    // note to self: $loginResult isn't a boolean true; it's either an associative array with user data, or it's false
    if ($loginResult) {
        // we store the user info (i.e. password and user id) in the current session
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

    <div id="main-login">
        <h2>Please log in.</h2>

        <?php
        // if our error message value is not empty
        if (!empty($error)) {
            // we use echo to print an error message
            // using paragraph style to print the error message in red
            // call htmlspecialchars on our $error value to convert any special chars (ex: <, >, &, and ") to html entities
            // examples: < becomes &lt;, > becomes &gt;, & becomes &amp;, " becomes &quot;
            // htmlspecialchars is used to prevent user input from being automatically interpreted as html; security measure against HTML injection
            echo '<p style="color: red;">' . htmlspecialchars($error) . '</p>';
        }
        ?>

        <!-- login form; action calls our login.php file; i.e. the code defined above -->
        <form method="POST" action="login.php">

            <!-- fields for username and password; both are required -->
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
            <!-- Explanation of how button type = submit works, and how it links to post action and login.php
            when we click <button type="submit">Login</button>, browser collects the form data, and submits it to the URL in the form’s action attribute; i.e. login.php
            server-side, PHP code in login.php checks if request method is POST, and then processes the data that's been submitted
            ergo, button itself doesn’t specify POST or URL, it just triggers form submission;  method and action attributes control how/where the form data goes -->
            <div>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</main>

<?php
require './templates/footer.php';
?>