<?php 
require_once('includes/config.inc.php');
?>

<!DOCTYPE html>
<html lang=en>
<head>
    <title>Assignment 1</title>
    <meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/results.css">
</head>
<body>
<header>
    <h1 class="center">COMP 3512 Assign1</h1>
</header>
<main>
    <section class="song-results">
        <h1>Search Results</h1>
        <h3>Title</h3>
        <h3>Artist</h3>
        <h3>Year</h3>
        <h3>Genre</h3>
        <h3>Popularity</h3><br>
        <button type="button">Show All</button>
        <button type="button"><a href="favorites.php">Add to Favorites</a></button>
        <button type="button"><a href='"single-song.php?id=".$row['song_id']."'>View</a></button>
    </section>


</main>
<footer>
    
    <div>&copy 2021 danvynguyen comp3512</div>
</footer>    

</body>
    
</html>