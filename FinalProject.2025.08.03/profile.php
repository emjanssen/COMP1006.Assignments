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

// Initialize error and success message variables
$success = '';
$error = '';


// Validate user login; if user is not logged in, code stops executing here
if (!isset($_SESSION['user_id'])) {
    require './templates/header.php';
    require './templates/footer.php';
    die("Access denied. Please login.");
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        // Trim user inputs
        $newUsername = trim($_POST['username'] ?? '');
        $newFirstName = trim($_POST['first_name'] ?? '');
        $newLastName = trim($_POST['last_name'] ?? '');
        $newEmail = trim($_POST['email_address'] ?? '');
        $newPhone = trim($_POST['phone_number'] ?? '');

        // Username update
        if (!empty($newUsername)) {
            if ($user->userExists($newUsername)) {
                $error = "That username is already in use. Please choose a different username.";
            } else {
                $updateSuccess = $user->updateUsername($userId, $newUsername);
                if ($updateSuccess) {
                    $success = "Username updated successfully.";
                    $_SESSION['username'] = $newUsername;
                } else {
                    $error = "Failed to update username. Please try again.";
                }
            }
        } else {
            $error = "Username cannot be empty.";
        }

        // First name update
        if (!empty($newFirstName)) {
            $updateSuccess = $user->updateFirstName($userId, $newFirstName);
            if ($updateSuccess) {
                $success = "First name updated successfully.";
            } else {
                $error = "Failed to update first name. Please try again.";
            }
        } else {
            $error = "First name cannot be empty.";
        }

        // Last name update
        if (!empty($newLastName)) {
            $updateSuccess = $user->updateLastName($userId, $newLastName);
            if ($updateSuccess) {
                $success = "Last name updated successfully.";
            } else {
                $error = "Failed to update last name. Please try again.";
            }
        } else {
            $error = "Last name cannot be empty.";
        }

        // Email address logic
        if (!empty($newEmail)) {
            if ($user->emailExists($newEmail)) {
                $error = "That email is already in use. Please choose a different email.";
            } else {
                if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                    $updateSuccess = $user->updateEmail($userId, $newEmail);
                    if ($updateSuccess) {
                        $success = "Email address updated successfully.";
                    } else {
                        $error = "Failed to update email address. Please try again.";
                    }
                } else {
                    $error = "Please enter a valid email address.";
                }
            }
        } else {
            $error = "Email address cannot be empty.";
        }

        // Phone number update
        if (!empty($newPhone)) {
            $updateSuccess = $user->updatePhoneNumber($userId, $newPhone);
            if ($updateSuccess) {
                $success = "Phone number updated successfully.";
            } else {
                $error = "Failed to update phone number. Please try again.";
            }
        } else {
            $error = "Phone number cannot be empty.";
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

            <!-- Echo outcomes of pressing update buttons -->

            <!-- if $success isn't empty, print success message -->
            <?php if (!empty($success)): ?>
                <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <!-- if $error isn't empty, print error message -->
            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <!-- checks if we have a $currentUser value; we called findUser() upon page load -->
            <?php if ($currentUser): ?>

                <!-- Update User Data Form -->

                <form method="POST" action="profile.php" id="form-profile-update-data">
                    <div>
                        <label for="username">New Username:</label>
                        <input type="text" id="username" name="username"
                               value="<?php echo htmlspecialchars($currentUser['username']); ?>"/>
                    </div>

                    <div>
                        <label for="first_name">New First Name:</label>
                        <input type="text" id="first_name" name="first_name"
                               value="<?php echo htmlspecialchars($currentUser['first_name']); ?>"/>
                    </div>

                    <div>
                        <label for="last_name">New Last Name:</label>
                        <input type="text" id="last_name" name="last_name"
                               value="<?php echo htmlspecialchars($currentUser['last_name']); ?>"/>
                    </div>

                    <div>
                        <label for="email_address">New Email Address:</label>
                        <input type="email" id="email_address" name="email_address"
                               value="<?php echo htmlspecialchars($currentUser['email_address']); ?>"/>
                    </div>

                    <div>
                        <label for="phone_number">New Phone Number:</label>
                        <input type="tel" id="phone_number" name="phone_number"
                               value="<?php echo htmlspecialchars($currentUser['phone_number']); ?>"/>
                    </div>

                    <div>
                        <button type="submit" name="update_profile">Update Profile</button>
                    </div>
                </form>

                <div id="forms-delete-logout">

                    <!-- Delete User Account -->

                    <form method="POST" action="functions/delete.php" id="form-profile-delete"
                          onsubmit="return confirm('Are you sure you would like to delete your account?');">
                        <input type="hidden" name="delete_user"/>
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
