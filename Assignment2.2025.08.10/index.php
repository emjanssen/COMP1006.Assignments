<?php
$pageTitle = 'Home';
$pageDescription = "This is the homepage.";
$pageKeywords = 'home, landing page';
require './templates/head.php';
require './templates/header.php';
?>
    <main id="index-main">
        <p>Welcome to [organization name]</p>

        <section id="index-main-links">

            <a href="login.php">Login</a>
            <a href="register.php">Create User</a>

    </main>

<?php
require './templates/footer.php';
?>