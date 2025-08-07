<?php
session_start();

require '../inc/database.php';
require '../inc/user.php';

$database = new Database();
$databaseConnection = $database->getDatabaseConnection();
$user = new User($databaseConnection);

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "User not logged in.";
    header("Location: ../about.php");
    exit;
}

$userId = $_SESSION['user_id'];
$tableContent = $user->getContentTable();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['user_image'])) {
    $sql = "UPDATE {$tableContent} SET user_image = :user_image WHERE user_id = :user_id";
    $stmt = $databaseConnection->prepare($sql);

    $fileName = $_FILES['user_image']['name'];
    $tempName = $_FILES['user_image']['tmp_name'];
    $uploadResult = $_FILES['user_image']['error'];

    if ($uploadResult === UPLOAD_ERR_OK) {
        $directory = "../uploads/";
        $targetFile = $directory . basename($fileName);
        $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $validExtensions = ["jpeg", "jpg", "png"];

        if (in_array($fileExtension, $validExtensions)) {
            $fileWasMoved = move_uploaded_file($tempName, $targetFile);

            if ($fileWasMoved) {
                $stmt->execute([
                    ':user_image' => $targetFile,
                    ':user_id' => $userId
                ]);
                $_SESSION['success'] = "Photo uploaded: " . htmlspecialchars($fileName);
            } else {
                $_SESSION['error'] = "Failed to move file.";
            }
        } else {
            $_SESSION['error'] = "Invalid file type.";
        }
    } else {
        $_SESSION['error'] = "Upload error (code $uploadResult)";
    }

    // Redirect back to the about page after handling
    header("Location: ../about.php");
    exit;
}
