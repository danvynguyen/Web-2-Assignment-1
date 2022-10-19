<?php 
require_once('includes/config.inc.php');
require_once('includes/helpers.inc.php');



?>

<!DOCTYPE html>
<html lang=en>
<head>
    <title>Assignment 1</title>
    <meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/search.css">
</head>
<body>
<header>
    <h1 class="center">COMP 3512 Assign1</h1>
    <nav class="center">
        <a href="home.php">Home</a> |
        <a href="search.php">Search</a> |
        <a href="favorites.php">Favorites</a> |
    </nav>
</header>
<main>
    <section class="song-search">
        <form action="results.php" method="post">
            <h1>Basic Song Search</h1>
            <label for="title">Title:</label>
            <input type="text" name="title" size=50/><br>
            <label for="artist">Artist:</label>
            <input type="text" name="artist" size=50/><br>
            <label for="genre">Genre:</label>
            <input type="text" name="genre" size=50/><br>
            <input type="radio" id="year" name="year" value="year">
            <label for="year">Year</label><br>
            <input type="radio" id="less-year" name="less_year" value="less_year">
            <label for="year">Less</label>
            <input type="text" name="max-year"/><br>
            <input type="radio" id="greater-year" name="greater_year" value="greater_year">
            <label for="year">Greater</label>
            <input type="text" name="min-year"/><br>
            <input type="radio" id="popularity" name="popularity" value="popularity">
            <label for="year">Popularity</label><br>
            <input type="radio" id="less-popular" name="less_popular" value="less_popular">
            <label for="year">Less</label>
            <input type="text" name="max-pop"/><br>
            <input type="radio" id="greater-popular" name="more_popular" value="more_popular">
            <label for="year">Greater</label>
            <input type="text" name="min-pop"/><br>
            <input type="submit" value="Search" />
        </form>
    </section>
    
</main>
<footer>
    
    <div>&copy 2021 danvynguyen comp3512</div>
</footer>    

</body>
    
</html>