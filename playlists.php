<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_playlist'])) {
    $name = $_POST['name'];
    $user_id = $_SESSION['id'];

    $stmt = $conn->prepare("INSERT INTO playlists (user_id, name) VALUES (?, ?)");
    $stmt->execute([$user_id, $name]);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_song'])) {
    $playlist_id = $_POST['playlist_id'];
    $song_id = $_POST['song_id'];

    $checkStmt = $conn->prepare("SELECT * FROM playlist_songs WHERE playlist_id = ? AND song_id = ?");
    $checkStmt->execute([$playlist_id, $song_id]);
    $exists = $checkStmt->fetch();

    if ($exists) {
        $error_message = "This song is already in the playlist.";
    } else {
        $stmt = $conn->prepare("INSERT INTO playlist_songs (playlist_id, song_id) VALUES (?, ?)");
        $stmt->execute([$playlist_id, $song_id]);
        $success_message = "Song added to playlist.";
    }
}

if (isset($_GET['delete'])) {
    $playlist_id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM playlists WHERE id = ? AND user_id = ?");
    $stmt->execute([$playlist_id, $_SESSION['id']]);
}

$stmt = $conn->prepare("SELECT * FROM playlists WHERE user_id = ?");
$stmt->execute([$_SESSION['id']]);
$playlists = $stmt->fetchAll();


$song_stmt = $conn->prepare("SELECT * FROM songs");
$song_stmt->execute();
$songs = $song_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Playlists</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include('handlers/header.php'); ?>

    <div class="container">
        <h1>Your Playlists</h1>
        
        <form method="post">
            <label for="name">Playlist Name:</label>
            <input type="text" id="name" name="name" required>
            <button type="submit" name="create_playlist">Create Playlist</button>
        </form>

        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php elseif (isset($success_message)): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>

        <h2>Existing Playlists</h2>
        <?php if (count($playlists) > 0): ?>
            <div class="playlists-container">
                <?php foreach ($playlists as $playlist): ?>
                    <div class="playlist">
                        <h3><?php echo htmlspecialchars($playlist['name']); ?></h3>
                        <a href="playlists.php?delete=<?php echo $playlist['id']; ?>" onclick="return confirm('Are you sure you want to delete this playlist?');">Delete</a>
                        
                        <h4>Add a Song to "<?php echo htmlspecialchars($playlist['name']); ?>"</h4>
                        <form method="post" class="add-song-form">
                            <input type="hidden" name="playlist_id" value="<?php echo $playlist['id']; ?>">
                            <select name="song_id">
                                <?php foreach ($songs as $song): ?>
                                    <option value="<?php echo $song['id']; ?>"><?php echo htmlspecialchars($song['title']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" name="add_song">Add Song</button>
                        </form>

                        <h4>Songs in "<?php echo htmlspecialchars($playlist['name']); ?>"</h4>
                        <?php
                        $song_stmt = $conn->prepare("SELECT songs.* FROM songs
                                                     INNER JOIN playlist_songs ON songs.id = playlist_songs.song_id
                                                     WHERE playlist_songs.playlist_id = ?");
                        $song_stmt->execute([$playlist['id']]);
                        $playlist_songs = $song_stmt->fetchAll();
                        ?>
                        <?php if (count($playlist_songs) > 0): ?>
                            <ul class="song-list">
                                <?php foreach ($playlist_songs as $song): ?>
                                    <li class="song-item">
                                        <div class="song-info">
                                            <p><?php echo htmlspecialchars($song['title']); ?></p>
                                            <a href="song.php?song_id=<?php echo $song['id']; ?>">Play</a>
                                            <audio controls>
                                                <source src="<?php echo $song['file_path']; ?>" type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>No songs in this playlist.</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No playlists found. Create one above!</p>
        <?php endif; ?>
    </div>

    <?php include('handlers/footer.php'); ?>
</body>
</html>
