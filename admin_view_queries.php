<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

$query = $conn->query("SELECT * FROM queries");
$queries = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Queries</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>User Queries</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Query</th>
            <th>Date</th>
        </tr>
        <?php foreach ($queries as $query): ?>
        <tr>
            <td><?php echo $query['id']; ?></td>
            <td><?php echo $query['username']; ?></td>
            <td><?php echo $query['query']; ?></td>
            <td><?php echo $query['date']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
