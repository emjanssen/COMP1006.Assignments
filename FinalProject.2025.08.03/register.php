<?php
// - - - Start Session - - - //

session_start();

// - - - Page Metadata - - - //

$pageTitle = 'Register';
$pageDescription = 'User registration page.';
$pageKeywords = 'profile, registration, users, accounts';

// - - - Head and Header - - - //

require './templates/head.php';

// - - - Required Files - - - //

require './inc/database.php';
require './inc/user.php';

/* - - - Run On Page Load - - - */

// Validate Login Status //

// if user is not logged in, the code for this file stops executing here
if (isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit;
}

$error = "";
$validationErrors = [];

/* - - - Form Functions - - - */

// Get User Inputs //

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate that all user inputs have been entered; if not, give the input a default value
    // Using ternary operator instead of full if/else statements
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $emailAddress = isset($_POST['email_address']) ? trim($_POST['email_address']) : '';
    $phoneNumber = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    // If password don't match, assign an error message.
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // If passwords match, create new Database() and User() objects.
        $database = new Database();
        $databaseConnection = $database->getDatabaseConnection();
        $user = new User($databaseConnection);

        // If username is not empty
        if (!empty($username)) {
            // If username already exists, assign error messages
            if ($user->userExists($username)) {
                $error = "That username is already in use. Please choose a different username.";
            }
        }
        // If email is not empty
        if (!empty($emailAddress)) {
            // Is email already exists, assign error message
            if ($user->emailExists($emailAddress)) {
                $error = "That email is already in use. Please choose a different email.";
            }
        }

        /* If $error is still its default value:
        - the passwords match
        - the username doesn't exist yet
        - the email doesn't exist yet
        - and we move on to further input validation via validation.php functions */
        if ($error === "") {
            {
                require_once './functions/validation.php';

                $usernameValidation = validateUsername($username);
                $firstNameValidation = validateFirstName($firstName);
                $lastNameValidation = validateLastName($lastName);
                $emailValidation = validateEmail($emailAddress);
                $phoneNumberValidation = validatePhoneNumber($phoneNumber);

                if ($usernameValidation === null && $firstNameValidation === null && $lastNameValidation === null && $emailValidation === null && $phoneNumberValidation === null) {

                    if ($user->registerUser($username, $password, $firstName, $lastName, $emailAddress, $phoneNumber)) {

                        // Get newly inserted user id
                        // PDO::lastInsertId() is a built-in function; returns ID of the last inserted row, if column is an AUTO_INCREMENT primary key
                        // has to be called on the same PDO connection that did the insert
                        $newUserId = $databaseConnection->lastInsertId();

                        // Create default content for this user
                        $user->createDefaultContent($newUserId);

                        header('Location: login.php');
                        exit;
                    } else {
                        $error = "Registration failed due to a system error.";
                    }
                } else {

                    // call all the validation functions; if any of them are not null, then we have an error message; add that error messages to the errors array
                    if ($usernameValidation !== null) {
                        $validationErrors[] = $usernameValidation;
                    }
                    if ($firstNameValidation !== null) {
                        $validationErrors[] = $firstNameValidation;
                    }
                    if ($lastNameValidation !== null) {
                        $validationErrors[] = $lastNameValidation;
                    }
                    if ($emailValidation !== null) {
                        $validationErrors[] = $emailValidation;
                    }
                    if ($phoneNumberValidation !== null) {
                        $validationErrors[] = $phoneNumberValidation;
                    }
                }
            }
        }
    }
}
?>
<body>

<div class="body-grid">

    <?php require './templates/header.php'; ?>

    <main class="global-main">

        <section id="register-landing">

            <!-- if $error isn't empty or our $validationErrors array isn't empty, display error messages in table -->
            <?php if (!empty($error) || !empty($validationErrors)): ?>

                <!-- Start of an HTML table with red-colored text for error messages -->
                <table style="color: red; margin-bottom: 1rem;">

                    <thead>
                    <tr>
                        <!-- Table header cell labeled "Errors" -->
                        <th>Errors</th>
                    </tr>
                    </thead>

                    <tbody>
                    <!-- check if our general $error variable is not empty -->
                    <?php if (!empty($error)): ?>
                        <tr>
                            <!-- print $error message in table cell -->
                            <td><?php echo htmlspecialchars($error); ?></td>
                        </tr>
                    <?php endif; ?>

                    <!-- use for each to loop through each item in our $validationErrors array -->
                    <?php foreach ($validationErrors as $message): ?>
                        <tr>
                            <!-- print out each of the validation errors -->
                            <td><?php echo htmlspecialchars($message); ?></td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>

                </table>

            <?php endif; ?>


            <!-- form for all the user inputs on the registration page; calls the register.php page (i.e. code further up this page) -->
            <form method="POST" action="register.php">
                <div>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div>
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                <div>
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
                <div>
                    <label for="email_address">Email Address:</label>
                    <input type="email" id="email_address" name="email_address" required>
                </div>
                <div>
                    <label for="phone_number">Phone number:</label>
                    <input type="tel" id="phone_number" name="phone_number" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <div>
                    <button type="submit">Register</button>
                </div>
            </form>
        </section>
    </main>

    <?php require './templates/footer.php'; ?>
</div>

</body>
