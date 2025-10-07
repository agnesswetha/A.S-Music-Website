<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

require 'db_connect.php';

$category = $_GET['category'];
$songs = $conn->prepare("SELECT * FROM songs WHERE genre = :category");
$songs->execute(['category' => $category]);
$songsList = $songs->fetchAll();

$songToPlay = $_GET['song_id'] ?? null;
?>

<html>
<head>
    <title><?php echo ucfirst($category); ?> Songs</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include('navBar.php'); ?>
    <div class="container">
        <h1><?php echo ucfirst($category); ?> Songs</h1>
        <ul class="song-list">
    <?php foreach ($songsList as $song): ?>
        <li class="song-item">
            <img src="<?php echo $song['artwork']; ?>" alt="<?php echo $song['title']; ?> Image" class="song-image">
            <a href="song.php?song_id=<?php echo $song['id']; ?>"><?php echo $song['title']; ?></a>
            <audio controls <?php if ($songToPlay == $song['id']) echo 'autoplay'; ?>>
                <source src="<?php echo $song['file_path']; ?>" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </li>
    <?php endforeach; ?>
</ul>

    </div>
</body>
</html>
