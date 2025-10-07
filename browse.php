<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include('handlers/config.php');
include('handlers/header.php');
?>

<div class="container">
    <h1>Browse Music Categories</h1>
    <p>Explore a wide range of music categories and discover new favorites!</p>
    
    <div class="search-bar">
        <input type="text" placeholder="Search categories..." id="searchInput">
    </div>

    <div class="categories">
        <?php
            $categories = [
                'Western Songs' => 'western',
                'Old Retro Songs' => 'retro',
                'Sad Songs' => 'sad',
                'Classical Songs' => 'classical',
                'Motivational Songs' => 'motivational',
                'Melody Songs' => 'melody'
            ];

            foreach ($categories as $category => $folder) {
                echo "<div class='category'>";
                echo "<h3>$category</h3>";
                echo "<a href='category.php?category=$folder'><img src='assets/images/artwork/$folder/$folder" . "2.jpg' alt='$category Image' class='category-image'></a>";
                echo "</div>";
            }
        ?>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        var filter = this.value.toLowerCase();
        var categories = document.getElementsByClassName('category');
        
        Array.from(categories).forEach(function(category) {
            var text = category.textContent || category.innerText;
            if (text.toLowerCase().indexOf(filter) > -1) {
                category.style.display = "";
            } else {
                category.style.display = "none";
            }
        });
    });
</script>

<?php include('handlers/footer.php'); ?>
