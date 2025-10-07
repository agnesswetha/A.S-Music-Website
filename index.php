<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>AS Music_Website_Player</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="scripts.js" defer></script>
</head>
<body>
    <?php include('handlers/navBar.php'); ?>
    <div class="container">
        <h1>Welcome to AS Music Website</h1>
        <p><h2>Your personalized music experience starts here.</h2></p>

        <h2>Music Directors</h2>
        <div class="directors">
            <?php
                $directors = [
                    'Harish Jayaraj' => 'Harris Jayaraj',
                    'Ilaiyaraaja' => 'Ilaiyaraaja',
                    'Anirudh Ravichander' => 'Anirudh Ravichander',
					'A.R. Rahman' => 'A.R. Rahman',
					'Yuvan Shankar Raja' => 'Yuvan Shankar Raja',
                ];

                foreach ($directors as $director => $image) {
                    echo "<div class='director'>";
                    echo "<a href='director.php?director=$image'><img src='assets/images/directors/$image.jpg' alt='$director' class='director-image'></a>";
                    echo "<h3>$director</h3>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
	<?php include('footer.php'); ?>
</body>
</html>
