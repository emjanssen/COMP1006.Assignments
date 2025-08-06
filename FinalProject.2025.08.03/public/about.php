<?php
// - - - Start Session - - - //

session_start();

// - - - Page Metadata - - - //

$pageTitle = 'About';
$pageDescription = 'About page.';
$pageKeywords = 'about, information';

// - - - Head - - - //

require '../templates/head.php';

?>

<!-- HTML Body -->

<body>

<div class="body-grid">

    <?php require '../templates/header.php'; ?>

    <main class="global-main">
        <section id="about-landing">
            <h2>This is our fictional organization.</h2>
            <p>This is some information about what we do.</p>
            <img src="../css/img/about_WinterTrees.png" alt="Illustration of trees in the winter.">
        </section>
    </main>

    <?php require '../templates/footer.php'; ?>

</div>

</body>
