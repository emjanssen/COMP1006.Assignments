<?php
// start session on load
session_start();

// validate user login
// if user is not logged in, print an error message and terminate page script
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit('Unauthorized');
}

// These rest of the code only runs if user is logged in //

/* - - - Classes - - - */

/* - - - Functions - - - */

/* - - - Run On Page Load - - - */

?>
ter.php';