<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$song_id = $_GET['song_id'] ?? null;

if ($song_id) {
  
    $stmt = $conn->prepare("SELECT * FROM songs WHERE id = :id");
    $stmt->execute(['id' => $song_id]);
    $song = $stmt->fetch();

    if ($song) {
 
        $user_id = $_SESSION['id']; 
        $insertStmt = $conn->prepare("INSERT INTO listening_history (user_id, song_id) VALUES (:user_id, :song_id)");
        $insertStmt->execute(['user_id' => $user_id, 'song_id' => $song_id]);
        header('Location: category.php?category=' . urlencode($song['genre']) . '&song=' . urlencode($song_id));
        exit;
    } else {
        echo "Song not found.";
        exit;
    }
} else {
    echo "No song specified.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($song['title']); ?> - Details</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    <?php include('navBar.php'); ?>
    <div class="container">
        <h1><?php echo htmlspecialchars($song['title']); ?> - Details</h1>
        <p><strong>Singer:</strong> <?php echo htmlspecialchars($song['singer']); ?></p>
        <p><strong>Actors:</strong> <?php echo htmlspecialchars($song['actors']); ?></p>
        <p><strong>Release Date:</strong> <?php echo htmlspecialchars($song['release_date']); ?></p>
        

        <audio id="audioPlayer">
            <source src="<?php echo htmlspecialchars($song['file_path']); ?>" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>
</body>
</html>
