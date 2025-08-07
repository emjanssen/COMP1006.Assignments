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

$tableContent = $user->getContentTable();

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['user_image'])) {
    $fileName = $_FILES['user_image']['name'];
    $tempName = $_FILES['user_image']['tmp_name'];
    $uploadResult = $_FILES['user_image']['error'];

    if ($uploadResult === UPLOAD_ERR_OK) {
        $directory = "../uploads/";
        $targetFile = $directory . basename($fileName);

        if (move_uploaded_file($tempName, $targetFile)) {
            $imagePathForDatabase = "uploads/" . $fileName;

            $sql = "UPDATE {$tableContent} SET user_image = :user_image WHERE user_id = :user_id";
            $stmt = $databaseConnection->prepare($sql);
            $stmt->execute([
                ':user_image' => $imagePathForDatabase,
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

// Fallback if no file submitted
$_SESSION['error'] = "No file uploaded.";
header("Location: ../about.php");
exit;
