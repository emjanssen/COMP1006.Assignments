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
    require './templates/header.php';
    require './templates/footer.php';
    die("Access denied. Please login.");
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
                </tr>

                <?php
                foreach ($listOfUsers as $returnedUser) {

                    // iterate over each value in $listOfUsers array
                    echo "<tr>";
                    // start a new table row
                    echo "<td>" . htmlspecialchars($returnedUser['user_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($returnedUser['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($returnedUser['first_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($returnedUser['last_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($returnedUser['email_address']) . "</td>";
                    echo "<td>" . htmlspecialchars($returnedUser['phone_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($returnedUser['created_at']) . "</td>";
                    echo "</tr>";
                    // end of the table row
                } ?>
            </table>
        </div>
    </main>

    <?php require './templates/footer.php'; ?>

</div>
</body>
