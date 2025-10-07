<?php
session_start();
require 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$song_id = $data['songId'];
$user_id = $_SESSION['id'];


$stmt = $conn->prepare("SELECT * FROM favorites WHERE user_id = :user_id AND song_id = :song_id");
$stmt->execute(['user_id' => $user_id, 'song_id' => $song_id]);
$fav = $stmt->fetch();

if ($fav) {
   
    $deleteStmt = $conn->prepare("DELETE FROM favorites WHERE user_id = :user_id AND song_id = :song_id");
    $deleteStmt->execute(['user_id' => $user_id, 'song_id' => $song_id]);
    echo json_encode(['success' => true, 'message' => 'Removed from favorites']);
} else {
   
   
    $insertStmt = $conn->prepare("INSERT INTO favorites (user_id, song_id) VALUES (:user_id, :song_id)");
    $insertStmt->execute(['user_id' => $user_id, 'song_id' => $song_id]);
    echo json_encode(['success' => true, 'message' => 'Added to favorites']);
}
?>
