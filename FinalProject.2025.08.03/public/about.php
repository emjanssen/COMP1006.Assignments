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

/* - - - Run On Page Load - - - */

/* - - - Helper Functions - - - */

/* - - - Form Functions - - - */
?>

<!-- HTML Body -->

<body>

<div class="body-grid">

    <?php require '../templates/header.php'; ?>

    <main class="global-main">

    </main>

    <?php require '../templates/footer.php'; ?>

</div>

</body>
