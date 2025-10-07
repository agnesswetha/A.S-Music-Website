<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == UPLOAD_ERR_OK) {
    $targetDir = 'assets/images/profile_pics/';
    $targetFile = $targetDir . basename($_FILES['profilePic']['name']);
    if (move_uploaded_file($_FILES['profilePic']['tmp_name'], $targetFile)) {
        $stmt = $conn->prepare("UPDATE users SET profilePic = ? WHERE id = ?");
        $stmt->execute([$targetFile, $_SESSION['id']]);
        header('Location: Account.php');
        exit;
    } else {
        echo "There was an error uploading the profile picture.";
    }
} else {
    echo "Invalid request.";
}
?>
