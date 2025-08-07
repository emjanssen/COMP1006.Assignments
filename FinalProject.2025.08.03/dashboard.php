<?php
// - - - Start Session - - - //

session_start();

// - - - Page Metadata - - - //

$pageTitle = 'Dashboard';
$pageDescription = 'Dashboard for all users.';
$pageKeywords = 'dashboard, users, accounts';

// - - - Head - - - //

require './templates/head.php';

// - - - Required Files - - - //
require './inc/database.php';
require './inc/user.php';

/* - - - Run On Page Load - - - */

// Validate user login; if user is not logged in, code stops executing here
if (!isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit;
}

// Create Database() and User() objects
$database = new Database();
$databaseConnection = $database->getDatabaseConnection();
$user = new User($databaseConnection);

?>

<!-- HTML Body -->

<body>

<div class="body-grid">

    <?php require './templates/header.php'; ?>

    <main class="global-main">

        <div id="landing-dashboard">

            <table id="dashboard-table">

                <?php
                $listOfUsers = $user->getAllUsers();
                ?>

                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Account Creation Date</th>
                    <th>Actions</th>
                </tr>

                <?php foreach ($listOfUsers as $returnedUser): ?>
                    <tr>
                        <td><?= htmlspecialchars($returnedUser['user_id']) ?></td>
                        <td><?= htmlspecialchars($returnedUser['username']) ?></td>
                        <td><?= htmlspecialchars($returnedUser['first_name']) ?></td>
                        <td><?= htmlspecialchars($returnedUser['last_name']) ?></td>
                        <td><?= htmlspecialchars($returnedUser['email_address']) ?></td>
                        <td><?= htmlspecialchars($returnedUser['phone_number']) ?></td>
                        <td><?= htmlspecialchars($returnedUser['created_at']) ?></td>
                        <td>
                            <form method="POST" action="functions/delete.php"
                                  onsubmit="return confirm('Are you sure you would like to delete this account?');">
                                <input type="hidden" name="delete_user" value="<?= $returnedUser['user_id'] ?>">
                                <button type="submit" class="delete-btn" id="button-dashboard-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>

    <?php require './templates/footer.php'; ?>

</div>
</body>

<form
        method="POST"
        action="functions/delete.php"
        id="form-profile-delete"
        onsubmit="return confirm('Are you sure you would like to delete your account?');"
>
    <input type="hidden" name="delete_user" />
    <button type="submit">Delete Your Account</button>
</form>