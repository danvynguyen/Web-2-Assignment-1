<?php 
//insert php code here
require_once('config.inc.php');

try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
 
    $galleries = getGalleries($pdo); 
    if ( isset($_GET['gallery']) ) { 
        $paintings = getPaintings($pdo, $_GET['gallery']); 
    } 
    $pdo = null; 
}
catch (PDOException $e) {
   die( $e->getMessage() );
}



?>

<!DOCTYPE html>
<html lang=en>
<head>
    <title>Assignment 1</title>
    <meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/single-song.css">
</head>
<body>
<header>
    <h1 class="center">COMP 3512 Assign1</h1>
</header>
<main>
    <h1 class="center">Song Information</h1>
    <p class="center">title, artist name, artist type, genre, year, duration</p>
    <br>
    <section class="song-data">
        <p>Analysis Data:</p>
            <ul>
                <li>bpm</li>
                <li>energy</li>
                <li>danceability</li>
                <li>liveness</li>
                <li>valence</li>
                <li>acoustics</li>
                <li>speechiness</li>
                <li>popularity</li>
            </ul>
    </section>
    
</main>
<footer>
    
    <div>&copy 2021 danvynguyen comp3512</div>
</footer>    

</body>
    
</html>