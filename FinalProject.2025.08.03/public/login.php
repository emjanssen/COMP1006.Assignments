<?php
// - - - Start Session - - - //

session_start();

// - - - Page Metadata - - - //

$pageTitle = 'Login';
$pageDescription = 'Login page.';
$pageKeywords = 'profile, login, users, accounts';

// - - - Head and Header - - - //

require '../templates/head.php';
require '../templates/header.php';

// - - - Required Files - - - //

require '../inc/database.php';
require '../inc/user.php';

/* - - - Run On Page Load - - - */

if (isset($_SESSION['user_id'])) {
    require '../templates/footer.php';
    die("You are already logged in.");
}

$error = "";

/* - - - Form Functions - - - */

/*  If request method is post, and username and password have been entered correctly:
    - Start session with login credentials
    - Redirect user to profile page
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $databaseConnection = $database->getDatabaseConnection();
    $user = new User($databaseConnection);

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

    $loginResult = $user->loginUser($username, $password);

    if ($loginResult) {
        $_SESSION['user_id'] = $loginResult['id'];
        $_SESSION['username'] = $loginResult['username'];

        header('Location: profile.php');
        exit;

    } else {
        $error = "Invalid username or password.";
    }
}
?>
    <main class="global-main">
        <!-- If $error has a value, echo error message in red -->
        <?php if (!empty($error)) { echo '<p style="color: red;">' . htmlspecialchars($error) . '</p>'; } ?>

        <form method="POST" action="login.php">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
        </form>
    </main>

<?php

// - - - Footer - - - //

require '../templates/footer.php';
?>