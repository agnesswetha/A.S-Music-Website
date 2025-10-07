<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

require 'db_connect.php';

$userQuery = $conn->prepare("SELECT * FROM users WHERE id = ?");
$userQuery->execute([$_SESSION['id']]);
$user = $userQuery->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include('navBar.php'); ?>
    <div class="container">
        <h1>Account Information</h1>
        <p><strong>First Name:</strong> <?php echo $user['firstName']; ?></p>
        <p><strong>Last Name:</strong> <?php echo $user['lastName']; ?></p>
        <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Sign Up Date:</strong> <?php echo $user['signUpDate']; ?></p>
        <p><strong>Profile Picture:</strong> <img id="profilePic" src="<?php echo $user['profilePic']; ?>" alt="Profile Picture"></p>

        <form id="updateProfilePicForm" method="post" enctype="multipart/form-data">
            <label for="profilePicInput">Update Profile Picture:</label>
            <input type="file" id="profilePicInput" name="profilePic" accept="image/*">
            <button type="submit">Update</button>
        </form>
    </div>
    <script src="assets/js/scripts.js"></script>
	<?php include('footer.php'); ?>

</body>
</html>
