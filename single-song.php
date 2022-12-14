<?php 
require_once('includes/config.inc.php');

session_start();

try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ( isset($_GET['song_id']) ) { 
        $songs = getSongs($pdo, $_GET['song_id']); 
    } 
    $pdo = null; 
}
catch (PDOException $e) {
   die( $e->getMessage() );
}

function getSongs($pdo, $id){
    $sql="SELECT * FROM songs INNER JOIN artists ON songs.artist_id=artists.artist_id INNER JOIN types ON artists.artist_type_id=types.type_id WHERE song_id=?";
    $statement = $pdo->prepare($sql); 
    $statement->bindValue(1, $id); 
    $statement->execute(); 
    return $statement->fetch(); 
}

?>

<!DOCTYPE html>
<html lang=en>
<head>
    <title>Assignment 1</title>
    <meta charset=utf-8>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Proxima Nova">
    <link rel="stylesheet" href="css/single-song.css">
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
    echo '<h1 class="center">'.$songs['title'].' by '.$songs['artist_name'].'</h1>';
    echo '<p class="center">'.$songs['title'].', '.$songs['artist_name'].' ('.$songs['type_name'].'), '.$songs['year'].', '.$songs['duration'].' seconds'.'</p>'; 
    
    ?>
    <br>
    <section class="song-data">
        <p>Analysis Data:</p>
            <ul>
                <li>BPM: 
                    <?php echo $songs['bpm'];?>
                </li>
                <li>Energy:    
                    <?php echo '<progress class="energy" value="'.$songs['energy'].'" max="100"></progress>';?>
                </li>
                <li>Danceability: 
                    <?php echo '<progress class="danceability" value="'.$songs['danceability'].'" max="100"></progress>';?>
                </li>
                <li>Liveness: 
                    <?php echo '<progress class="liveness" value="'.$songs['liveness'].'" max="100"></progress>';?>
                </li>
                <li>Valence: 
                    <?php echo '<progress class="valence" value="'.$songs['valence'].'" max="100"></progress>';?>
                </li>
                <li>Acoustics:
                    <?php echo '<progress class="acoustics" value="'.$songs['acousticness'].'" max="100"></progress>';?>
                </li>
                <li>Speechiness: 
                    <?php echo '<progress class="speechiness" value="'.$songs['speechiness'].'" max="100"></progress>';?>
                </li>
                <li>Popularity: 
                    <?php echo '<progress class="popularity" value="'.$songs['popularity'].'" max="100"></progress>';?>
                </li>
            </ul>
    </section>
    
</main>
<footer>
    
    <div class="center">&copy 2022 copyright danvynguyen</div>
</footer>    

</body>
    
</html>