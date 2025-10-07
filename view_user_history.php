<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $query = $conn->prepare("SELECT * FROM listening_history WHERE user_id = :user_id");
    $query->bindParam(':user_id', $user_id);
    $query->execute();
    $history = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User History</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>User Listening History</h1>
    <table>
        <tr>
            <th>Song</th>
            <th>Timestamp</th>
        </tr>
        <?php foreach ($history as $entry): ?>
        <tr>
            <td><?php echo $entry['song_title']; ?></td>
            <td><?php echo $entry['timestamp']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
