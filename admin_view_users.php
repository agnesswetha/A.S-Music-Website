<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

$servername = "127.0.0.1:3307";
$username = "root";
$password = "";
$dbname = "music_website"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>View Users</title>
</head>
<body>
<div class="admin-dashboard-container">
    <h2>All Users</h2>
    <div class="admin-user-details">
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php while ($user = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><a href="view_user_history.php?user_id=<?php echo $user['id']; ?>">View History</a> | <a href="delete_user.php?user_id=<?php echo $user['id']; ?>">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
</body>
</html>
