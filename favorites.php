<?php 
//insert php code here
require_once('includes/config.inc.php');
require_once('includes/helpers.inc.php');

session_start();
print_r($_SESSION);

try { 
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $gateway = new songDB($conn);
    
        if (!isset($_SESSION['favorites'])) {
            $_SESSION['favorites']=array();
        }
    
        //add song to $_SESSION['favorites']
        if (isset($_GET['song_id']) && $_GET['button']=="Add to Favorites") {
            
            $songs=$gateway->search($_GET['song_id'],"song_id");
            foreach ($songs as $s) {
                array_push($_SESSION['favorites'],array("song_id"=>$s['song_id'],"title"=>$s['title'],"artist_name"=>$s['artist_name'],"year"=>$s['year'],"genre_name"=>$s['genre_name'],"popularity"=>$s['popularity']));
            }
        }
        //removes song from $_SESSION['favorites']
        else if (isset($_GET['song_id']) && $_GET['button'] == "Remove"){
            $key = array_search($_GET['song_id'], $_SESSION['favorites']);
            unset($_SESSION['favorites'][$key]);
        }
        //removes all songs from $_SESSION['favorites']
        else {
            if (! empty($_SESSION['favorites']) ) {
                foreach ($_SESSION['favorites'] as $f) {
                //$_SESSION['favorites']= array_diff(array("song_id"=>$f['song_id'],"title"=>$f['title'],"artist_name"=>$f['artist_name'],"year"=>$f['year'],"genre_name"=>$f['genre_name'],"popularity"=>$f['popularity']));
                    unset($_SESSION['favorites']);
                }
            }
        }
    
        /*if (isset($_GET['song_id']) && $_GET["button1"] == 'Add to Favorites') {
            $song_id = $_GET['song_id'];

            array_push($_SESSION['favorites'], $song_id);
        } 
        else if (isset($_GET['song_id']) && $_GET["button2"] == 'Remove'){
            $key = array_search($_GET['song_id'], $_SESSION['favorites']);

            unset($_SESSION['song_ids'][$key]);
        }*/
    
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Proxima Nova">
    <link rel="stylesheet" href="css/results.css">
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
    <section class="song-results">
        <h1>Favorites</h1>
        <table>
            <tr>
                <th>Title</th>
                <th>Artist</th>
                <th>Year</th>
                <th>Genre</th>
                <th>Popularity</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            //if (isset($songs) && count($songs)>0) {
            if (isset($_SESSION['favorites'])){
                
                foreach( $_SESSION['favorites'] as $f ) {
                    
                    $songs=$gateway->search($f['song_id'],"song_id");
                        
                        foreach ($songs as $s) {
                            echo '<tr>';
                            echo '<td>';
                            echo $s['title'];
                            echo '</td>';
                            echo '<td>';
                            echo $s['artist_name'];
                            echo '</td>';
                            echo '<td>';
                            echo $s['year'];
                            echo '</td>';
                            echo '<td>';
                            echo $s['genre_name'];
                            echo '</td>';
                            echo '<td>';
                            echo '<progress value="'.$s['popularity'].'" max="100"></progress>';
                            echo '</td>';
                            echo '<td>';
                            echo '<form action="favorites.php" method="get">';
                            echo '<input type="button" onclick="location=\'single-song.php?song_id='.$s['song_id'].'\'" value="View">';
                            echo '<input type="button" onclick="location=\'favorites.php?song_id='.$s['song_id'].'&button=Remove\'" name="button" value="Remove">';
                            echo '<input type="button" onclick="location=\'favorites.php\'" name="button2" value="Remove All">';
                            echo '</form>';               
                            echo '</td>';
                            echo '<td>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    }
                }
                
            ?>
        </table>
        
    </section>
    
</main>
<footer>
    
    <div class="center">&copy 2022 copyright danvynguyen</div>
</footer>    

</body>
    
</html>