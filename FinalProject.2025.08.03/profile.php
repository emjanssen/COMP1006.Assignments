<?php
// - - - Start Session - - - //

session_start();

// - - - Page Metadata - - - //

$pageTitle = 'Profile';
$pageDescription = 'User profile page.';
$pageKeywords = 'profile, users, accounts';

// - - - Head - - - // 

require './templates/head.php';

// - - - Required Files - - - //

require './inc/database.php';
require './inc/user.php';

/* - - - Run On Page Load - - - */

// Initialize arrays for error and success message variables
$errors = [];
$successes = [];

// Validate user login; if user is not logged in, code stops executing here
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

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

/* - - - Form Functions - - - */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {

    require_once './functions/validation.php';

    // Trim inputs
    $newUsername  = trim($_POST['username'] ?? '');
    $newFirstName = trim($_POST['first_name'] ?? '');
    $newLastName  = trim($_POST['last_name'] ?? '');
    $newEmail     = trim($_POST['email_address'] ?? '');
    $newPhone     = trim($_POST['phone_number'] ?? '');

    // Run validation
    $usernameValidation  = validateUsername($newUsername);
    $firstNameValidation = validateFirstName($newFirstName);
    $lastNameValidation  = validateLastName($newLastName);
    $emailValidation     = validateEmail($newEmail);
    $phoneValidation     = validatePhoneNumber($newPhone);

    // Collect validation errors
    if ($usernameValidation !== null)  $errors[] = $usernameValidation;
    if ($firstNameValidation !== null) $errors[] = $firstNameValidation;
    if ($lastNameValidation !== null)  $errors[] = $lastNameValidation;
    if ($emailValidation !== null)     $errors[] = $emailValidation;
    if ($phoneValidation !== null)     $errors[] = $phoneValidation;

    // Only proceed if all inputs are valid
    if (empty($errors)) {
        // Username
        if ($newUsername !== $currentUser['username']) {
            if ($user->userExists($newUsername)) {
                $errors[] = "That username is already in use.";
            } else {
                if ($user->updateUsername($userId, $newUsername)) {
                    $successes[] = "Username updated successfully.";
                    $_SESSION['username'] = $newUsername;
                } else {
                    $errors[] = "Failed to update username.";
                }
            }
        }

        // First name
        if ($newFirstName !== $currentUser['first_name']) {
            if ($user->updateFirstName($userId, $newFirstName)) {
                $successes[] = "First name updated successfully.";
            } else {
                $errors[] = "Failed to update first name.";
            }
        }

        // Last name
        if ($newLastName !== $currentUser['last_name']) {
            if ($user->updateLastName($userId, $newLastName)) {
                $successes[] = "Last name updated successfully.";
            } else {
                $errors[] = "Failed to update last name.";
            }
        }

        // Email
        if ($newEmail !== $currentUser['email_address']) {
            if ($user->emailExists($newEmail)) {
                $errors[] = "That email is already in use.";
            } else {
                if ($user->updateEmail($userId, $newEmail)) {
                    $successes[] = "Email updated successfully.";
                } else {
                    $errors[] = "Failed to update email.";
                }
            }
        }

        // Phone
        if ($newPhone !== $currentUser['phone_number']) {
            if ($user->updatePhoneNumber($userId, $newPhone)) {
                $successes[] = "Phone number updated successfully.";
            } else {
                $errors[] = "Failed to update phone number.";
            }
        }

        // After updates, refresh current user info from database
        $currentUser = $user->findUser($userId);
        if (!$currentUser) {
            error_log("Failed to refresh user data after update");
            $errors[] = "Profile updated but unable to refresh user data.";
        } else {
            header("Location: profile.php");
            exit;
        }
    }
}

?>

<!-- HTML Body -->

<body>

<div class="body-grid">

    <?php require './templates/header.php'; ?>

    <main class="global-main">

        <div id="profile-landing">

            <?php if (!empty($errors) || !empty($successes)): ?>
                <table border="1">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Message</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($errors as $err): ?>
                        <tr style="color: red;">
                            <td>Error</td>
                            <td><?php echo htmlspecialchars($err); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php foreach ($successes as $msg): ?>
                        <tr style="color: green;">
                            <td>Success</td>
                            <td><?php echo htmlspecialchars($msg); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <!-- checks if we have a $currentUser value; we called findUser() upon page load -->
            <?php if ($currentUser): ?>

                <!-- Update User Data Form -->

                <form method="POST" action="profile.php" id="form-profile-update-data">
                    <div>
                        <label for="username">New Username:</label>
                        <input
                                type="text"
                                id="username"
                                name="username"
                                value="<?php echo htmlspecialchars($currentUser['username']); ?>"
                        />
                    </div>
                    <div>
                        <label for="first_name">New First Name:</label>
                        <input
                                type="text"
                                id="first_name"
                                name="first_name"
                                value="<?php echo htmlspecialchars($currentUser['first_name']); ?>"
                        />
                    </div>
                    <div>
                        <label for="last_name">New Last Name:</label>
                        <input
                                type="text"
                                id="last_name"
                                name="last_name"
                                value="<?php echo htmlspecialchars($currentUser['last_name']); ?>"
                        />
                    </div>
                    <div>
                        <label for="email_address">New Email Address:</label>
                        <input
                                type="email"
                                id="email_address"
                                name="email_address"
                                value="<?php echo htmlspecialchars($currentUser['email_address']); ?>"
                        />
                    </div>
                    <div>
                        <label for="phone_number">New Phone Number:</label>
                        <input
                                type="tel"
                                id="phone_number"
                                name="phone_number"
                                value="<?php echo htmlspecialchars($currentUser['phone_number']); ?>"
                        />
                    </div>
                    <div>
                        <button type="submit" name="update_profile">Update Profile</button>
                    </div>
                </form>

                <div id="forms-delete-logout">

                    <!-- Delete User Account -->

                    <form
                            method="POST"
                            action="functions/delete.php"
                            id="form-profile-delete"
                            onsubmit="return confirm('Are you sure you would like to delete your account?');"
                    >
                        <input type="hidden" name="delete_user" />
                        <button type="submit">Delete Your Account</button>
                    </form>

                    <!-- Logout -->

                    <form method="POST" action="functions/logout.php" id="form-profile-logout">
                        <button type="submit">Logout</button>
                    </form>

                </div>

                <!-- if $currentUser is false/null, we echo a user not found message -->
            <?php else: ?>
                <p>User not found.</p>
            <?php endif; ?>

        </div>

    </main>

    <?php require './templates/footer.php'; ?>

</div>
</body>
