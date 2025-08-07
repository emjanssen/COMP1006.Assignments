<?php
session_start();

require '../inc/database.php';
require '../inc/user.php';

$database = new Database();
$databaseConnection = $database->getDatabaseConnection();
$user = new User($databaseConnection);

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}
$userId = $_SESSION['user_id'];

// ✅ Correct usage of the getter
$tableContent = $user->getContentTable();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['user_image'])) {

    // ✅ Correct SQL line
    $sql = "UPDATE {$tableContent} SET user_image = :user_image WHERE user_id = :user_id";
    $stmt = $databaseConnection->prepare($sql);
    $fileName = $_FILES['user_image']['name'];
    $tempName = $_FILES['user_image']['tmp_name'];
    $uploadResult = $_FILES['user_image']['error'];

    if ($uploadResult === UPLOAD_ERR_OK) {
        $directory = "./uploads/";
        $targetFile = $directory . basename($fileName);
        $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $validExtensions = array("jpeg", "jpg", "png");

        if (in_array($fileExtension, $validExtensions)) {
            $fileWasMoved = move_uploaded_file($tempName, $targetFile);

            if ($fileWasMoved) {
                $stmt->execute(array(
                    ':user_image' => $targetFile,
                    ':user_id' => $userId
                ));
                echo "Uploaded: " . htmlspecialchars($fileName);
            } else {
                echo "Failed to move file: " . htmlspecialchars($fileName);
            }
        } else {
            echo "Invalid file type for: " . htmlspecialchars($fileName);
        }
    } else {
        echo "Error uploading file: " . htmlspecialchars($fileName) . " (Error code: $uploadResult)";
    }
}
