<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include('handlers/navBar.php'); ?>
    <div class="container">
        <h1>Contact Us</h1>
        <form action="send_contact.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea><br>

            <button type="submit">Send</button>
        </form>
    </div>
    <?php include('handlers/footer.php'); ?>
</body>
</html>
