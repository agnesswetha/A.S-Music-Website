<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['admin_username']; ?></h1>
    <div class="admin-dashboard">
        <a href="admin_view_users.php">View Users</a>
        <a href="admin_view_queries.php">View Queries</a>
        <a href="view_user_history.php">View User History</a>
        <a href="delete_user.php">Delete User</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>


----