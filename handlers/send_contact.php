<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

  
    echo "Name: " . htmlspecialchars($name) . "<br>";
    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "Message: " . nl2br(htmlspecialchars($message)) . "<br>";
    
    header('Location: contact.php?success=1');
    exit;
}
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
        <?php if (isset($_GET['success'])): ?>
            <p>Your message has been sent successfully!</p>
        <?php else: ?>
            <p>There was an error sending your message. Please try again later.</p>
        <?php endif; ?>
    </div>
    <?php include('handlers/footer.php'); ?>
</body>
</html>
