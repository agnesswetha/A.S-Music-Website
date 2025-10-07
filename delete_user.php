<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $conn->prepare("DELETE FROM users WHERE id = :id");
    $query->bindParam(':id', $id);
    if ($query->execute()) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user.";
    }
    header('Location: admin_view_users.php');
    exit();
} else {
    echo "Invalid request.";
}
?>
