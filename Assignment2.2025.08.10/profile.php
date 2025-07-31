<?php

// Note: leaving detailed comments in because I find them useful for learning; would remove them from real life production code

// start session on page load
session_start();

// page metadata
$pageTitle = 'Profile';
$pageDescription = "Manage your account details here.";
$pageKeywords = 'profile, user, settings';

// include necessary templates and classes
require './templates/head.php';
require './templates/header.php';
require './inc/database.php';
require './inc/user.php';

/* - - - Run On Page Load - - - */

// check if user is logged in; otherwise, deny access
if (!isset($_SESSION['user_id'])) {
    // run footer code if user isn't logged in; otherwise, it doesn't show at all, because die() terminates the script early
    // there is surely a better way to handle this footer situation but i'm going to stick with this for now
    require './templates/footer.php';
    die("Access denied. Please login.");
}

/* - If we make it to this part of the run-on-page-load code, it's because the user is logged in. - */

/* Why we still create a new database and user object, even though these objects were created during login.php code:

- HTTP is stateless, and PHP is per-request
- when login.php finishes executing and sends a redirect, everything in memory is gone; all variables are wiped (not just the objects, but everything)
- so even though we created Database and User objects in login.php, PHP won't persist object instances between page loads
- i.e. each page (example: profile.php) must recreate these objects

1. When we log in, these values are saved: $_SESSION['user_id'] = $loginResult['id'] and $_SESSION['username'] = $loginResult['username']
these values are saved on the server, and linked to the user's session cookie
even after login.php script finishes, these session values persist as long as the session is active (until we close the browser, or logout, or the session expires, etc.)
so we have access to $_SESSION['user_id'] and $_SESSION['username'] even though login.php has finished executing its code
basically everything gets wiped except the $_SESSION values

2. When we redirect user to login.php upon successful login:
    // first we start the same session again/resume the existing session
    session_start();

    // $_SESSION is populated from the session file (which is likely stored on the server, and would be tied to the user's session ID)
    // if a user id hasn't already been set, then the page dies/profile.php script terminates
        if (!isset($_SESSION['user_id'])) {
        die("Access denied");
        }

3. We recreate Database and User objects in profile.php:
    $database = new Database();
    $databaseConnection = $database->getDatabaseConnection();
    $user = new User($databaseConnection);

    even though they are new instances, they'll still have access to the same user data from the session, i.e. the data entered by the user during login */

// create database instance
$database = new Database();
$databaseConnection = $database->getDatabaseConnection();
$user = new User($databaseConnection);

// retrieve user ID from session
$userId = $_SESSION['user_id'];

// initialize message variables
$success = '';
$error = '';

// fetch current user data
// will use this value further down in form
$currentUser = $user->findUser($userId);

/* - - - Form Functions - - - */

// in-future, will refactor update code into one function, instead of repeating myself
// for now, leaving functions separate to keep everything a bit easier to learn/manage
// not going to comment each update function because the process is essentially the same for each
// in-future, also want to update user class to have an emailExists() method to check if the email is still in use
// and need to include validation for first and last name inputs as well (not just whitespace, contains letter chars, etc.)

// form submission to update username
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $newUsername = trim($_POST['username']);

    // if input for $newUsername isn't empty
    if (!empty($newUsername)) {
        // and if the $newUsername doesn't already belong to an existing user (checking that via userExists() from our user object)
        if ($user->userExists($newUsername)) {
            // assign error message content if the message is already taken
            $error = "That username is already in use. Please choose a different username.";
        } else {
            // if $newUsername doesn't exist already, attempt to update username
            // we called the updateUsername() function from our user class, and pass in the current user id, along with the updated username data
            // assign the result to $updateSuccess
            $updateSuccess = $user->updateUsername($userId, $newUsername);
            // if the update is successful
            if ($updateSuccess) {
                // assign a success message
                $success = "Username updated successfully.";
                // update current $_SESSION value for username to the new username
                $_SESSION['username'] = $newUsername;
            } // if username was not updated successfully, assign an error message
            else {
                $error = "Failed to update username. Please try again.";
            }
        }
    } // if $newUsername is empty, assign an error message value
    else {
        $error = "Username cannot be empty.";
    }
}


// form submission to update first name
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['first_name'])) {
    $newFirstName = trim($_POST['first_name']);

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
}

// form submission to update last name
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['last_name'])) {
    $newLastName = trim($_POST['last_name']);

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
}


// form submission to update email address
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email_address'])) {
    $newEmail = trim($_POST['email_address']);

    if (!empty($newEmail)) {
        // using filter_var() for email validation; built-in PHP function that's used to validate data
        // its inputs are the value being validated (i.e. the email address, and the type of filter)
        // in this case, FILTER_VALIDATE_EMAIL checks where the input is a properly formed email address
        // if the validation returns true, then we move on to trying to update the email address
        if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $updateSuccess = $user->updateEmail($userId, $newEmail);
            if ($updateSuccess) {
                $success = "Email address updated successfully.";
            } else {
                $error = "Failed to update email address. Please try again.";
            }
            // if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) returned false, it's not a valid, and we assign an error message value
        } else {
            $error = "Please enter a valid email address.";
        }
    } else {
        $error = "Email address cannot be empty.";
    }
}
?>

    <!-- - - - Forms for Updating Data - - - -->

    <main>
        <div id="main-profile">
            <h2>Your Profile</h2>
            <br>

            <!-- if our success variable isn't empty -->
            <?php if (!empty($success)): ?>

                <!-- echo out our success message -->
                <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <!-- if our error variable isn't empty -->
            <?php if (!empty($error)): ?>
                <!-- echo out our error message -->
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <!-- checks if we have a $currentUser value; we called findUser() upon page load
             if findUser() returned a valid user record, we'll have an array with id and username
             if it didn't return a valid record, $currentUser will have a value of false or null
             -->
            <?php if ($currentUser): ?>

                <!-- having the values show twice here is extraneous but i just kind of like it for overall visibility; would remove the duplicate echoes from production code -->

                <div id="profile-current-user-date">
                    <!-- echo out the current user data values -->
                    <p>Username: <?php echo htmlspecialchars($currentUser['username']); ?></p>
                    <p>First name: <?php echo htmlspecialchars($currentUser['first_name']); ?></p>
                    <p>Last name: <?php echo htmlspecialchars($currentUser['last_name']); ?></p>
                    <p>Email address: <?php echo htmlspecialchars($currentUser['email_address']); ?></p>
                </div>

                <div id="profile-form-update-instructions">
                    <p>The fields below show your current user date.
                    <p>You may update your username, first name, last name, or password.</p>
                    <p>Please update each piece of data individually.</p>
                </div>

                <!-- forms for updating user data; each form action is linked to profile.php code -->

                <!-- in-future, will refactor this all into one form; for now, i just wanted to learn the basics of updating user data -->

                <!-- update username -->
                <form method="POST" action="profile.php">
                    <div>
                        <label for="username">Please enter your new username here: </label>
                        <input type="text" id="username" name="username"
                               value="<?php echo htmlspecialchars($currentUser['username']); ?>"/>
                    </div>
                    <div>
                        <button type="submit">Update Username</button>
                    </div>
                </form>

                <!-- update first name -->
                <form method="POST" action="profile.php">
                    <div>
                        <label for="first_name">Please enter your new first name here: </label>
                        <input type="text" id="first_name" name="first_name"
                               value="<?php echo htmlspecialchars($currentUser['first_name']); ?>"/>
                    </div>
                    <div>
                        <button type="submit">Update First Name</button>
                    </div>
                </form>

                <!-- update last name -->
                <form method="POST" action="profile.php">
                    <div>
                        <label for="last_name">Please enter your new last name here: </label>
                        <input type="text" id="last_name" name="last_name"
                               value="<?php echo htmlspecialchars($currentUser['last_name']); ?>"/>
                    </div>
                    <div>
                        <button type="submit">Update Last Name</button>
                    </div>
                </form>

                <!-- update email -->
                <form method="POST" action="profile.php">
                    <div>
                        <label for="email_address">Please enter your new email address here: </label>
                        <input type="email" id="email_address" name="email_address"
                               value="<?php echo htmlspecialchars($currentUser['email_address']); ?>"/>
                    </div>
                    <div>
                        <button type="submit">Update Email</button>
                    </div>
                </form>

                <!-- update photo -->
                <!-- process: on upload, the file is saved to a temp location (a directory/folder) in the server's cache, so we can inspect/validate before adding it to database
                 we do not immediately add the media file to the database; instead, in the database we save the path to the temp file
                 before uploading, we want to potentially check file extension,size, etc.
                 we may also want to uniquely name the file before we save it to the database; we can use a unique session id generated by the server, and include in the file name
                 then we use PHP built-in move_uploaded_file function to specify: where the file currently is, where we want is to reside permanently, and what we want to rename the file
                 only going to allow one photo (i.e. profile photo) for this project; will expand to managing multiple photos on final project
                 -->

                <form method="POST" action="photo.php" enctype="multipart/form-data">
                    <div>
                        <input type="file" id="profile_photo" name="profile_photo" required />
                    </div>
                    <div>
                        <button type="submit">Upload Profile Photo</button>
                    </div>
                </form>


                <!-- Delete User Function -->

                <!-- form calls the delete.php file; delete.php run-on-page-load code in turn calls deleteUSer() from the user.php page -->
                <!-- onsubmit pops up a notification asking for user to confirm delete -->
                <form method="POST" action="delete.php"
                      onsubmit="return confirm('Are you sure you would like to delete your account?');">
                    <input type="hidden" name="delete_user"/>
                    <button type="submit">Delete Your Account</button>
                </form>

                <!-- Logout Function -->

                <form method="POST" action="logout.php">
                    <button type="submit">Logout</button>
                </form>

                <!-- if $currentUser is false/null, we echo a user not found message -->
            <?php else: ?>
                <p>User not found.</p>
            <?php endif; ?>
        </div>
    </main>

<?php
// run footer code here if the user was logged in properly when they loaded the page
require './templates/footer.php';
?>