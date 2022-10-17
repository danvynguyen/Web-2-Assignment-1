<?php 
require_once('includes/config.inc.php');

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
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/single-song.css">
</head>
<body>
<header>
    <h1 class="center">COMP 3512 Assign1</h1>
</header>
<main>
    <h1 class="center">Song Information</h1>
    <!--<p class="center">title, artist name, artist type, genre, year, duration</p>-->
    <?php 
    echo '<p class="center">'.$songs['title'].', '.$songs['artist_name'].' ('.$songs['type_name'].'), '.$songs['year'].', '.$songs['duration'].' seconds'.'</p>'; 
    
    ?>
    <br>
    <section class="song-data">
        <p>Analysis Data:</p>
            <ul>
                <li>bpm: <?php echo $songs['bpm'];?></li>
                <li>energy: <?php echo $songs['energy'];?></li>
                <li>danceability: <?php echo $songs['danceability'];?></li>
                <li>liveness: <?php echo $songs['liveness'];?></li>
                <li>valence: <?php echo $songs['valence'];?></li>
                <li>acoustics: <?php echo $songs['acousticness'];?></li>
                <li>speechiness: <?php echo $songs['speechiness'];?></li>
                <li>popularity: <?php echo $songs['popularity'];?></li>
            </ul>
    </section>
    
</main>
<footer>
    
    <div class="center">&copy 2021 danvynguyen comp3512</div>
</footer>    

</body>
    
</html>