<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

require 'db_connect.php';

$query = $_GET['query'] ?? '';
$songsList = [];

if ($query) {
    $stmt = $conn->prepare("SELECT * FROM songs WHERE title LIKE :query OR singer LIKE :query");
    $stmt->execute(['query' => '%' . $query . '%']);
    $songsList = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results for "<?php echo htmlspecialchars($query); ?>"</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include('navBar.php'); ?>
    <div class="container">
        <h1>Search Results for "<?php echo htmlspecialchars($query); ?>"</h1>
        <?php if (count($songsList) > 0): ?>
            <ul class="song-list">
                <?php foreach ($songsList as $song): ?>
                    <li>
                        <img src="<?php echo $song['artwork']; ?>" alt="<?php echo $song['title']; ?> Image" class="song-image">
                        <a href="song.php?song=<?php echo $song['id']; ?>"><?php echo $song['title']; ?></a>
                        <audio controls>
                            <source src="<?php echo $song['file_path']; ?>" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No results found for your search.</p>
        <?php endif; ?>
    </div>
</body>
</html>
