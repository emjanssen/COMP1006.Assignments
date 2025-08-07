<?php
// - - - Start Session - - - //

session_start();

// - - - Success Values - - //

if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

// - - - Page Metadata - - - //

$pageTitle = 'About';
$pageDescription = 'About page.';
$pageKeywords = 'about, information';

// - - - Head - - - //

require './templates/head.php';

// - - - Required Files - - - //

require './inc/database.php';
require './inc/user.php';

/* - - - Run On Page Load - - - */

// defining as empty arrays, because there will be no value for users who aren't logged in
$currentUser = [];
$userContent = [];

// Initialize error and success message variables
$error = '';
$titleError = '';
$bodyError = '';
$success = '';

if (isset($_SESSION['user_id'])) {
    // Create Database() and User() objects
    $database = new Database();
    $databaseConnection = $database->getDatabaseConnection();
    $user = new User($databaseConnection);

    // Get user_id from the current session
    $userId = $_SESSION['user_id'];
    // Get current user using that user_id
    $currentUser = $user->findUser($userId);
    // Get current content data for user
    $userContent = $user->getUserContent($userId);
}

/* - - - Form Functions - - - */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_content'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    require_once './functions/validation.php';

    $userId = $_SESSION['user_id'];
    $title = trim($_POST['user_title'] ?? '');
    $body = trim($_POST['user_body'] ?? '');
    $titleUpdated = false;
    $bodyUpdated = false;

// Title validation and update
    $titleValidation = validateTitle($title);
    if ($titleValidation === null) {
        $titleUpdated = $user->updateUserTitle($userId, $title);
        if (!$titleUpdated) {
            $error = "Failed to update title";
        }
    } else {
        $titleError = $titleValidation;
    }

// Body validation and update (separate from title validation)
    $bodyValidation = validateBody($body);
    if ($bodyValidation === null) {
        $bodyUpdated = $user->updateUserBody($userId, $body);
        if (!$bodyUpdated) {
            $error = $error ? $error . " and body" : "Failed to update body";
        }
    } else {
        $bodyError = $bodyValidation;
    }

    if ($titleUpdated || $bodyUpdated) {
        $userContent = $user->getUserContent($userId);  // Get fresh data first
        $_SESSION['success'] = "Your content was updated.";
        header("Location: about.php");
        exit;
    }
}
?>

<!-- HTML Body -->

<body>

<div class="body-grid">

    <?php require './templates/header.php'; ?>

    <main class="global-main">
        <section id="about-landing">

            <!-- Echo outcomes of pressing update buttons -->
            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <!-- // - - - About One - - - // -->

            <div id="about-one">

                <form method="POST" action="about.php" id="form-profile-update-content">
                    <div>
                        <label for="user_title">Title:</label>
                        <input
                                type="text"
                                id="user_title"
                                name="user_title"
                                value="<?php echo htmlspecialchars($_POST['user_title'] ?? $userContent['user_title'] ?? ''); ?>"
                        />
                        <?php if (!empty($titleError)): ?>
                            <p style="color: red;"><?php echo htmlspecialchars($titleError); ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="user_body">Body:</label>
                        <textarea id="user_body"
                                  name="user_body"><?php echo htmlspecialchars($_POST['user_body'] ?? $userContent['user_body'] ?? ''); ?></textarea>
                        <?php if (!empty($bodyError)): ?>
                            <p style="color: red;"><?php echo htmlspecialchars($bodyError); ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <button type="submit" name="update_content">Update Content</button>
                    </div>
                </form>

                <!-- // - - - About Two - - - // -->

                <div id="about-two">
                    <h2>
                        <!-- is user isn't logged in, display default message; if they are, display their content -->
                        <?php echo !empty($userContent['user_title'])
                                ? htmlspecialchars($userContent['user_title'])
                                : "This is the default title value."; ?>
                    </h2>

                    <p>
                        <?php echo !empty($userContent['user_body'])
                                ? htmlspecialchars($userContent['user_body'])
                                : "This is the default body value."; ?>
                    </p>

                    <figure>
                        <img src="css/img/about_WinterTrees.png" alt="Illustration of trees in the winter.">
                        <figcaption>User photo and caption go here.</figcaption>
                    </figure>
                </div>
            </div>
        </section>
    </main>

    <?php require './templates/footer.php'; ?>

</div>

</body>
