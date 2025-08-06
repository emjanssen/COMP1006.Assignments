<?php
// - - - Start Session - - - //

session_start();

// - - - Page Metadata - - - //

$pageTitle = 'About';
$pageDescription = 'About page.';
$pageKeywords = 'about, information';

// - - - Head - - - //

require '../templates/head.php';

// - - - Required Files - - - //

require '../inc/database.php';
require '../inc/user.php';
require '../public/about.php';

/* - - - Run On Page Load - - - */

    if (isset($_SESSION['user_id'])) {
        // Create Database() and User() objects
        $database = new Database();
        $databaseConnection = $database->getDatabaseConnection();
        $user = new User($databaseConnection);

        // Get user_id from the current session
        $userId = $_SESSION['user_id'];
        // Get current user using that user_id
        $currentUser = $user->findUser($userId);
    } ?>

<!-- HTML Body -->

<body>

<div class="body-grid">

    <?php require '../templates/header.php'; ?>

    <main class="global-main">
        <section id="about-landing">
            <h2><?php echo htmlspecialchars($currentUser['user_title'] ?? ''); ?></h2>
            <p><?php echo htmlspecialchars($currentUser['user_body'] ?? ''); ?></p>
                <figure>
                    <img src="../css/img/about_WinterTrees.png" alt="Illustration of trees in the winter.">
                    <figcaption>User photo and caption go here.</figcaption>
            </figure>
        </section>
    </main>

    <?php require '../templates/footer.php'; ?>

</div>

</body>
