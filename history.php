<?php
session_start();
require 'db_connect.php'; 


if (!isset($_SESSION['loggedin']) || !isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();
$user_id = $user['id'];

if (!$user_id) {
    echo "User not found!";
    exit;
}


$stmt = $conn->prepare("SELECT songs.id AS song_id, songs.title, songs.singer, listening_history.listened_at 
                         FROM listening_history 
                         JOIN songs ON listening_history.song_id = songs.id 
                         WHERE listening_history.user_id = ? 
                         ORDER BY listening_history.listened_at DESC");
$stmt->execute([$user_id]);
$history = $stmt->fetchAll();

include('handlers/header.php'); 
?>

<div class="container">
    <h2>Listening History</h2>
    <p>Review the songs you've listened to recently.</p>

    <?php if (count($history) > 0): ?>
        <?php foreach ($history as $entry): ?>
            <a href="song.php?song_id=<?php echo htmlspecialchars($entry['song_id']); ?>" class="history-link">
                <div class="history-block">
                    <h3><?php echo htmlspecialchars($entry['title']) . ' by ' . htmlspecialchars($entry['singer']); ?></h3>
                    <p>Listened on: <?php echo htmlspecialchars($entry['listened_at']); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No listening history found.</p>
    <?php endif; ?>
</div>

<?php include('handlers/footer.php');?>
