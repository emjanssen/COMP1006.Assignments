<?php
// - - - Start Session - - - //

session_start();

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

// Initialize error and success message variables
$success = '';
$error = '';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_content'])) {

        $newTitle = trim($_POST['user_title'] ?? '');
        $newBody = trim($_POST['user_body'] ?? '');

        // Validate and update title
        if (validateTitle($newTitle) === null) {
            if ($user->updateUserTitle($userId, $newTitle)) {
                $success = "Title updated successfully.";
            } else {
                $error = "Failed to update title.";
            }
        } else {
            $error = "Invalid title.";
        }

        // Validate and update body
        if (validateBody($newBody) === null) {
            if ($user->updateUserBody($userId, $newBody)) {
                $success = isset($success) ? $success . " Body updated successfully." : "Body updated successfully.";
            } else {
                $error = "Failed to update body.";
            }
        } else {
            $error = "Invalid body.";
        }

        $userContent = $user->getUserContent($userId);
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

            <!-- if $success isn't empty, print success message -->
            <?php if (!empty($success)): ?>
                <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <!-- if $error isn't empty, print error message -->
            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <div id="about-one">

                <!-- Update Content -->

                <form method="POST" action="about.php" id="form-profile-update-content">
                    <div>
                        <label for="user_title">Title:</label>
                        <input type="text" id="user_title" name="user_title"
                               placeholder="Please enter your title here."
                               value="<?php echo htmlspecialchars($currentUser['user_title'] ?? ''); ?>"/>
                    </div>
                    <div>
                        <label for="user_body">Body:</label>
                        <textarea name="user_body" id="user_body" placeholder="Please enter your body content here."
                                  maxlength="300"><?php echo htmlspecialchars($currentUser['user_body'] ?? ''); ?></textarea>
                    </div>
                    <div>
                        <button type="submit" name="update_content">Update Content</button>
                    </div>
                </form>
            </div>

            <div id="about-two">

                <h2><?php echo !empty($userContent['user_title']) ? htmlspecialchars($userContent['user_title']) : "Please login to enter a title here."; ?></h2>
                <p><?php echo !empty($userContent['user_body']) ? htmlspecialchars($userContent['user_body']) : "You'll also be able to enter some body content here."; ?></p>
                <figure>
                    <img src="css/img/about_WinterTrees.png" alt="Illustration of trees in the winter.">
                    <figcaption>User photo and caption go here.</figcaption>
                </figure>
            </div>
        </section>
    </main>

    <?php require './templates/footer.php'; ?>

</div>

</body>
