<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Navigation Bar</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <nav class="navbar">
        <img src="assets/images/logo.png" alt="Logo" class="logo">
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="browse.php">Browse</a>
            <a href="export_csv.php">Export Songs CSV</a>
            <a href="playlists.php">Playlists</a>
            <a href="history.php">History</a>
            <a href="Account.php">Account</a>
            <a href="logout.php">Logout</a>
        </div>
        <div class="search-form">
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="Search for songs, artists..." required>
                <button type="submit">Search</button>
            </form>
        </div>
    </nav>
</body>
</html>
