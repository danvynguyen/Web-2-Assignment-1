<?php 
require_once 'includes/config.inc.php';
require_once 'includes/helpers.inc.php';

session_start();

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $gateway = new songDB($conn);
    $song=$gateway->getAll();
    $artists=$gateway->callArtist();
    $genres=$gateway->callGenre();
}
catch (Exception $e){
    die($e->getMessage());
}

?>

<!DOCTYPE html>
<html lang=en>
<head>
    <title>Assignment 1</title>
    <meta charset=utf-8>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Proxima Nova">
    <link rel="stylesheet" href="css/search.css">
</head>
<body>
<header>
    <h1 class="center">McDeezers</h1>
    <nav class="center">
        <a href="home.php">Home</a> |
        <a href="search.php">Search</a> |
        <a href="results.php">Songs</a> |
        <a href="favorites.php">Favorites</a>
    </nav>
</header>
<main>
    <section class="song-search">
        <h1>Song Search</h1>
        <p>Please select a field: </p>
        <form action="results.php" method="get">
            <input type="radio" name="form" value="title">
            <label for="title">Title:</label>
            <input type="text" name="title" class="title" size=20/><br>
            <input type="radio" name="form" value="artist_name" size=20>
            <label for="artist">Artist:</label>
            <select name="artist">
                <option size=20></option>
            <?php 
                foreach ($artists as $a) {
                    echo '<option value="'.$a['artist_name'].'">'.$a['artist_name'].'</option>';
                }
            ?>
            </select><br>
            <input type="radio" name="form" value="genre_name">
            <label for="genre">Genre:</label>
            <select name="genre">
                <option size=20></option>
            <?php
                foreach ($genres as $g) {
                    echo '<option value="'.$g['genre_name'].'">'.$g['genre_name'].'</option>';
                }
            ?>
            </select><br>
            <input type="radio" id="year" name="form" value="year">
            <label for="year">Year</label><br>
            <input type="radio" id="less-year" name="year" value="less">
            <label for="year">Less</label>
            <input type="number" name="max-year" size=20/><br>
            <input type="radio" id="greater-year" name="year" value="greater">
            <label for="year">Greater</label>
            <input type="number" name="min-year" size=20/><br>
            <input type="radio" id="popularity" name="form" value="popularity">
            <label for="year">Popularity</label><br>
            <input type="radio" id="less-popular" name="popularity" value="less">
            <label for="year">Less</label>
            <input type="text" name="max-pop" class="max-pop" size=20/><br>
            <input type="radio" id="greater-popular" name="popularity" value="more">
            <label for="year">Greater</label>
            <input type="text" name="min-pop" class="min-pop" size=20/><br>
            <input type="submit" value="Search" />
        </form>
    </section>
    
</main>
<footer>
    
    <div class="center">&copy 2022 copyright danvynguyen</div>
</footer>    

</body>
    
</html>