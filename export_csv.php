<?php
require 'db_connect.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=songs.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Title', 'Music', 'Album', 'Genre', 'Duration', 'Path', 'Artwork', 'Singer', 'Actors', 'Release Date'));

$songsQuery = $conn->query("SELECT * FROM songs");
while ($row = $songsQuery->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}
fclose($output);
exit;
?>
