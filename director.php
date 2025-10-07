<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
require 'db_connect.php';

if (!isset($_GET['director'])) {
    echo "No director specified.";
    exit;
}

$director = $_GET['director'];


$stmt = $conn->prepare("SELECT title, artwork, album, genre, duration, singer, actors, release_date FROM songs WHERE director = ?");
$stmt->execute([$director]);
$songs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($director); ?>'s Songs</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include('navBar.php'); ?>
    <div class="container">
        <h1><?php echo htmlspecialchars($director); ?>'s Songs</h1>
        <div class="songs-list">
            <?php
                foreach ($songs as $song) {
                  
                    $filePath = "music/{$director}/" . urlencode($song['title']) . ".mp3";


             
                    echo "<div class='song'>";
                    echo "<img src='{$song['artwork']}' alt='{$song['title']}' class='song-image'>";
                    echo "<p>Title: {$song['title']}</p>";
                    echo "<p>Album: {$song['album']}</p>";
                    echo "<p>Genre: {$song['genre']}</p>";
                    echo "<audio controls>";
                    echo "<source src='$filePath' type='audio/mpeg'>";
                    echo "Your browser does not support the audio element.";
                    echo "</audio>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</body>
</html>
