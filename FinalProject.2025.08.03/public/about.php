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
            <h2>User title goes here.</h2>
            <p>User blog entry goes here.</p>
                <figure>
                    <img src="../css/img/about_WinterTrees.png" alt="Illustration of trees in the winter.">
                    <figcaption>User photo and caption go here.</figcaption>
            </div>
        </section>
    </main>

    <?php require '../templates/footer.php'; ?>

</div>

</body>
