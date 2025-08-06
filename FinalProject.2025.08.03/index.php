<?php
// - - - Start Session - - - //

session_start();

// - - - Page Metadata - - - //

$pageTitle = 'Home';
$pageDescription = 'Home page.';
$pageKeywords = 'home';

// - - - Head - - - //

require './templates/head.php'; ?>

<!-- - - - HTML Body - - -->

<body>

<div class="body-grid">

    <?php require './templates/header.php'; ?>

    <main class="global-main">

        <section id="landing-page-welcome">

            <h1>Welcome to our website.</h1>

            <h2>Please check out the following links:</h2>

            <div id="landing-page-links">

            <h3><a href="about.php">About</a></h3>
            <h3><a href="login.php">Login</a></h3>
            <h3><a href="register.php">Register</a></h3>
            <h3><a href="profile.php">Profile</a></h3>
            <h3><a href="dashboard.php">Dashboard</a></h3>

            </div>

        </section>

    </main>

    <?php require './templates/footer.php'; ?>

</div>

</body>