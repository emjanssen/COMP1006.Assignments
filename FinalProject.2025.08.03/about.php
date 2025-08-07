<?php
// - - - Start Session - - - //

session_start();

// - - - Success/Error Values - - //

// if we have success or error messages saved into our sessions, save those to a variable, then unset the error/success message
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
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
$titleError = '';
$bodyError = '';

// Create DB/User objects just once
if (isset($_SESSION['user_id'])) {
    $database = new Database();
    $databaseConnection = $database->getDatabaseConnection();
    $user = new User($databaseConnection);
    $userId = $_SESSION['user_id'];
    $currentUser = $user->findUser($userId);
}

// always get latest user content after the post redirect
// this should let us echo out the photo content for logged-in user
if (isset($user) && isset($userId)) {
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

    // title validation and update
    $titleValidation = validateTitle($title);
    // if the result of calling validateTitle() is null, we have no errors
    if ($titleValidation === null) {
        $titleUpdated = $user->updateUserTitle($userId, $title);
        if (!$titleUpdated) {
            $titleError = "Failed to update title";
        }
    } else {
        $titleError = $titleValidation;
    }

    // body validation and update
    $bodyValidation = validateBody($body);
    // if the result of calling validateBody() is null, we have no errors
    if ($bodyValidation === null) {
        $bodyUpdated = $user->updateUserBody($userId, $body);
        if (!$bodyUpdated) {
            $bodyError = "Failed to update body";
        }
    } else {
        $bodyError = $bodyValidation;
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

                <!-- Form for title and body -->
                <!-- title and body contents are echoing properly into form input fields on update/page refresh -->
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

                <!-- separate form for updating image -->
                <!-- don't need to try to echo anythng into form here -->
                <form method="POST" action="./functions/photo.php" enctype="multipart/form-data" id="form-image">
                    <div id="inner-form-image">
                        <div>
                            <input type="file" id="user_image" name="user_image"/>
                        </div>
                        <div>
                            <button type="submit" id="update-photo">Update Photo</button>
                        </div>
                    </div>
                </form>

                <!-- // - - - About Two - - - // -->

                <div id="about-two">
                    <!-- is user isn't logged in, display default body message; if they are, display their content -->
                    <h2>
                        <?php echo !empty($userContent['user_title'])
                                ? htmlspecialchars($userContent['user_title'])
                                : "This is the default title value."; ?>
                    </h2>

                    <!-- is user isn't logged in, display default body message; if they are, display their content -->
                    <p>
                        <?php echo !empty($userContent['user_body'])
                                ? htmlspecialchars($userContent['user_body'])
                                : "This is the default body value."; ?>
                    </p>

                    <!-- is user isn't logged in, display image; if they are, display their content -->
                    <figure>
                        <?php if (!empty($userContent['user_image'])): ?>
                            <img src="<?php echo ($userContent['user_image']); ?>"
                                 alt="User uploaded image">
                        <?php else: ?>
                            <img src="css/img/about_WinterTrees.png" alt="Illustration of trees in the winter.">
                        <?php endif; ?>
                    </figure>
                </div>
            </div>
        </section>
    </main>

    <?php require './templates/footer.php'; ?>

</div>

</body>
