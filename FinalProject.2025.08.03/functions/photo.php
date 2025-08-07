<?php
session_start();

require '../inc/database.php';
require '../inc/user.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "User not logged in.";
    header("Location: ../about.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Initialize database and user
$database = new Database();
$databaseConnection = $database->getDatabaseConnection();
$user = new User($databaseConnection);

// call getter function so we can get private variable from user class
$tableContent = $user->getContentTable();

// image upload: assign variables for user's filename, temp file name, error message/result of upload, and file size
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['user_image'])) {
    $fileName = $_FILES['user_image']['name'];
    $tempName = $_FILES['user_image']['tmp_name'];
    $uploadResult = $_FILES['user_image']['error'];
    $fileSize = $_FILES['user_image']['size'];
    // setting file size limit to 500 KB in bytes
    $maxSize = 500 * 1024;

    // if image is bigger than 500 KB, save error message, redirect to about page, and stop upload here
    if ($fileSize > $maxSize) {
        $_SESSION['error'] = "Image file is too large. Max file size is 2MB.";
        header("Location: ../about.php");
        exit;
    }

    // if we didn't get an error, assign a target directory for the file
    if ($uploadResult === UPLOAD_ERR_OK) {

        // - - - Do not change this directory target - - - //
        // it works locally to add photos to the uploads folder
        // this points to uploads folder on server filesystem, relative to this script in photo.php
        $directory = "../uploads/";

        $targetFile = $directory . basename($fileName);

        // - - - Leaving in for Debug Purposes - - - //

        /* When I try to use (move_uploaded_file($tempName, $targetFile)), I get the following die() message:
        / Upload directory is not writable: /home/Elizabeth200627709/public_html/summer2025/COMP1006-PHP/COMP1006.Assignments/FinalProject.2025.08.03/uploads */
        if (!is_dir($directory)) {
            die("Upload directory does not exist: " . realpath($directory));
        }
        if (!is_writable($directory)) {
            die("Upload directory is not writable: " . realpath($directory));
        }

        // - - - - - - - - - - - - - - - - - - - - - //

        if (move_uploaded_file($tempName, $targetFile)) {

            $sql = "UPDATE {$tableContent} SET user_image = :user_image WHERE user_id = :user_id";
            $stmt = $databaseConnection->prepare($sql);
            $stmt->execute([
                ':user_image' => $targetFile,
                ':user_id' => $userId
            ]);

            $_SESSION['success'] = "Photo uploaded.";
        } else {
            $_SESSION['error'] = "Failed to move uploaded file.";
        }
    } else {
        $_SESSION['error'] = "Upload error.";
    }

    header("Location: ../about.php");
    exit;
}

// Fallback error and redirect if no file submitted
$_SESSION['error'] = "No file uploaded.";
header("Location: ../about.php");
exit;
