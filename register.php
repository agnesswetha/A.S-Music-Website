<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $email2 = $_POST['email2'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $profilePic = 'assets/images/default-profile.png'; // Default profile picture

   
    if ($email != $email2) {
        $error = "Emails do not match!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } 
    
   
    elseif ($password != $password2) {
        $error = "Passwords do not match!";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z]{4,})(?=.*\d)(?=.*[!@#$%^&*()_+{}:"|<>?~`\-=\[\]\\;\',.\/]).{8,}$/', $password)) {
        $error = "Password must contain at least 1 uppercase letter, 4 lowercase letters, 1 number, 1 special character, and be at least 8 characters long.";
    } 
    
    else {
        $password = password_hash($password, PASSWORD_BCRYPT);

     
        if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == UPLOAD_ERR_OK) {
            $targetDir = 'assets/images/profile_pics/';
            $targetFile = $targetDir . basename($_FILES['profilePic']['name']);
            if (move_uploaded_file($_FILES['profilePic']['tmp_name'], $targetFile)) {
                $profilePic = $targetFile;
            } else {
                $error = "There was an error uploading the profile picture.";
            }
        }

   
        if (!isset($error)) {
            $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, username, email, password, signUpDate, profilePic) VALUES (:firstName, :lastName, :username, :email, :password, NOW(), :profilePic)");
            $stmt->bindValue(':firstName', $firstName);
            $stmt->bindValue(':lastName', $lastName);
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':password', $password);
            $stmt->bindValue(':profilePic', $profilePic);
            $stmt->execute();

            header('Location: login.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="scripts.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form method="post" id="registerForm" enctype="multipart/form-data">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required><br>

            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required><br>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="email2">Confirm Email:</label>
            <input type="email" id="email2" name="email2" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="password2">Confirm Password:</label>
            <input type="password" id="password2" name="password2" required><br>

            <label for="profilePic">Profile Picture:</label>
            <input type="file" id="profilePic" name="profilePic" accept="image/*"><br>

            <button type="submit">Register</button>
        </form>

        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    </div>
	<?php include('footer.php'); ?>

</body>
</html>
