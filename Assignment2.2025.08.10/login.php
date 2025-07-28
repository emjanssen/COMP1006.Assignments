<?php
// page metadata
$pageTitle = 'Login';
$pageDescription = "This is the login page.";
$pageKeywords = 'home, landing page';

// required files
require './templates/head.php';
require './templates/header.php';
require './inc/database.php';
require './inc/user.php';

// use built-in function to begin session so we can manage login state
session_start();

// initialize variable for storing error message
$error = "";

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
    */
    $loginResult = $user->loginUser($username, $password);

    // if the login is successful; i.e. $loginResult contains user data (not false)
    // note to self: $loginResult isn't a boolean true; it's either an associative array with user data, or it's false
    if ($loginResult) {
        // we store the user info (i.e. password and user id) in the current session
        // we know the id because it's part of our $loginResult value
        $_SESSION['user_id'] = $loginResult['id'];
        $_SESSION['username'] = $loginResult['username'];

        // and we redirect the user to the dashboard (in-future, would probably make a user profile page to redirect to from successful login)
        header('Location: dashboard.php');
        exit;

    } else {
        // if the login fails, assign the error message string to our error variable
        $error = "Invalid username or password.";
    }
}
?>

<!-- Page Title -->
<h1>Login</h1>

<!-- Error Message -->
<?php
if (!empty($error)) {
    echo '<p style="color: red;">' . htmlspecialchars($error) . '</p>';
}
?>

<!-- Login Form -->
<form method="POST" action="login.php">

    <!-- Username Input -->
    <div>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required>
    </div>

    <br>

    <!-- Password Input -->
    <div>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required>
    </div>

    <br>

    <!-- Submit Button -->
    <div>
        <button type="submit">Login</button>
        <a href="register.php">Register</a>
    </div>

</form>

<?php
// Include the footer template
require './templates/footer.php';
?>
