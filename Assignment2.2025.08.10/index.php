<?php
$pageTitle = 'Home';
$pageDescription = "This is the homepage.";
$pageKeywords = 'home, landing page';
require './templates/head.php';
require './templates/header.php';
?>
    <main>
        <div id="main-index">
        <h2>Welcome to Fictional Organization. Please log in or create an account.</h2>

        <section id="index-main-links">

            <h3><a href="login.php">Login</a></h3>
            <h3><a href="register.php">Create User</a></h3>
        </div>
    </main>

<?php
require './templates/footer.php';
?>