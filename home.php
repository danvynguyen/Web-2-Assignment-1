<?php 
require_once('includes/config.inc.php');

session_start();

try { 
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    
    $topGenres = getTopGenres($pdo);
    
    $topArtists = getTopArtists($pdo);
    
    $mostPopular = getMostPopular($pdo);
    
    $oneHitWonders = getOneHitWonders($pdo);
    
    $longestAcoustic = getLongestAcoustic($pdo);
    
    $club = getClub($pdo);
    
    $running = getRunning($pdo);
    
    $studying = getStudying($pdo);
    
    $pdo = null; 
} 
catch (PDOException $e) { 
    die( $e->getMessage() ); 
} 

//gets and outputs top genres
function getTopGenres($pdo){
    $sql="SELECT genre_name, COUNT(*) FROM genres INNER JOIN songs ON genres.genre_id=songs.genre_id GROUP BY genre_name ORDER BY COUNT(*) DESC LIMIT 10";
    $result = $pdo->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC); 
}

function outputTopGenres($topGenres) {
    echo "<ul>";
    foreach ($topGenres as $row) {
        echo "<li>";
        echo $row['genre_name'] . "<br/>";
        echo "</li>";
    }
    echo "</ul>";
}

//gets and outputs top artists
function getTopArtists($pdo){
    $sql="SELECT artist_name, COUNT(*) FROM artists INNER JOIN songs ON artists.artist_id=songs.artist_id GROUP BY artist_name ORDER BY COUNT(*) DESC LIMIT 10";
    $result = $pdo->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC); 
}

function outputTopArtists($topArtists) {
    echo "<ul>";
    foreach ($topArtists as $row) { 
        echo "<li>";
        echo $row['artist_name'] . "<br/>";
        echo "</li>";
    }
    echo "</ul>";
}

//gets and outputs most popular songs
function getMostPopular($pdo){
    $sql="SELECT song_id, title, artist_name, popularity FROM artists INNER JOIN songs ON artists.artist_id=songs.artist_id GROUP BY title ORDER BY popularity DESC LIMIT 10";
    $result = $pdo->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC); 
}

function outputMostPopular($mostPopular) {
    echo "<ul>";
    foreach ($mostPopular as $row) { 
        echo "<li>";
        echo '<a href="single-song.php?song_id='.$row['song_id'].'">'.$row['title'] . ' by ' . $row['artist_name'] . '</a><br/>'; 
        echo "</li>";
    }
    echo "</ul>";
}

//gets and outputs one hit wonders
function getOneHitWonders($pdo){
    $sql="SELECT song_id, title, artist_name, COUNT(*), popularity FROM artists INNER JOIN songs ON artists.artist_id=songs.artist_id GROUP BY artist_name HAVING COUNT(*)=1 ORDER BY popularity DESC LIMIT 10";
    $result = $pdo->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC); 
}

function outputOneHitWonders($oneHitWonders) {
    echo "<ul>";
    foreach ($oneHitWonders as $row) {
        echo "<li>";
        echo '<a href="single-song.php?song_id='.$row['song_id'].'">'.$row['title'] . ' by ' . $row['artist_name'] . '</a><br/>';
        echo "</li>";
    }
    echo "</ul>";
}

//gets and outputs longest acoustic songs
function getLongestAcoustic($pdo){
    $sql="SELECT * FROM artists INNER JOIN songs ON artists.artist_id=songs.artist_id WHERE acousticness > 40 GROUP BY title ORDER BY duration DESC LIMIT 10";
    $result = $pdo->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC); 
}

function outputLongestAcoustic($longestAcoustic) {
    echo "<ul>";
    foreach ($longestAcoustic as $row) {
        echo "<li>";
        echo '<a href="single-song.php?song_id='.$row['song_id'].'">'.$row['title'] . ' by ' . $row['artist_name'] . '</a><br/>';
        echo "</li>";
    }
    echo "</ul>";
}

//gets and outputs at the club songs
function getClub($pdo){
    $sql="SELECT song_id, title, artist_name, danceability*1.6+energy*1.4 as sustainability FROM artists INNER JOIN songs ON artists.artist_id=songs.artist_id WHERE danceability > 80 GROUP BY title ORDER BY sustainability DESC LIMIT 10";
    $result = $pdo->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC); 
}

function outputClub($club) {
    echo "<ul>";
    foreach ($club as $row) {
        echo "<li>";
        echo '<a href="single-song.php?song_id='.$row['song_id'].'">'.$row['title'] . ' by ' . $row['artist_name'] . '</a><br/>';
        echo "</li>";
    }
    echo "</ul>";
}

//gets and outputs running songs
function getRunning($pdo){
    $sql="SELECT song_id, title, artist_name, energy*1.3+valence*1.6 as sustainability FROM artists INNER JOIN songs ON artists.artist_id=songs.artist_id WHERE bpm>120 AND bpm<125 GROUP BY title ORDER BY sustainability DESC LIMIT 10";
    $result = $pdo->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC); 
}

function outputRunning($running) {
    echo "<ul>";
    foreach ($running as $row) {
        echo "<li>";
        echo '<a href="single-song.php?song_id='.$row['song_id'].'">'.$row['title'] . ' by ' . $row['artist_name'] . '</a><br/>';
        echo "</li>";
    }
    echo "</ul>";
}

//gets and outputs studying songs
function getStudying($pdo){
    $sql="SELECT song_id, title, artist_name, (acousticness*0.8)+(100-speechiness)+(100-valence) as sustainability FROM artists INNER JOIN songs ON artists.artist_id=songs.artist_id WHERE bpm>100 AND bpm<115 AND speechiness>1 AND speechiness<20 GROUP BY title ORDER BY sustainability DESC LIMIT 10";
    $result = $pdo->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC); 
}

function outputStudying($studying) {
    echo "<ul>";
    foreach ($studying as $row) { 
        echo "<li>";
        echo '<a href="single-song.php?song_id='.$row['song_id'].'">'.$row['title'] . ' by ' . $row['artist_name'] . '</a><br/>'; 
        echo "</li>";
    }
    echo "</ul>";
}

?>

<!DOCTYPE html>
<html lang=en>
<head>
    <title>Assignment 1</title>
    <meta charset=utf-8>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Proxima Nova">
    <link rel="stylesheet" href="css/home.css">
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
    <?php 
        echo '<div class="list">';
        echo "<h3> Top Genres </div>";
        outputTopGenres($topGenres);
        echo '</div>';
    
        echo '<div class="list">';
        echo "<h3>Top Artists</h3>";
        outputTopArtists($topArtists);
        echo '</div>';
    
        echo '<div class="list">';
        echo "<h3>Most Popular Songs</h3>";
        outputMostPopular($mostPopular);
        echo '</div>';
    
        echo '<div class="list">';
        echo "<h3>One Hit Wonders</h3>";
        outputOneHitWonders($oneHitWonders);
        echo '</div>';
    
        echo '<div class="list">';
        echo "<h3>Longest Acoustic Songs</h3>";
        outputLongestAcoustic($longestAcoustic);
        echo '</div>';
    
        echo '<div class="list">';
        echo "<h3>At the Club</h3>";
        outputClub($club);
        echo '</div>';
    
        echo '<div class="list">';
        echo "<h3>Running Songs</h3>";
        outputRunning($running);
        echo '</div>';
    
        echo '<div class="list">';
        echo "<h3>Studying</h3>";
        outputStudying($studying);
        echo '</div>';

    ?> 
    
</main>
<footer>
    
    <div class="center">&copy 2022 copyright danvynguyen</div>
</footer>    

</body>
    
</html>