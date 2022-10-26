<?php 
require_once('includes/config.inc.php');
require_once('includes/helpers.inc.php');

session_start();

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $gateway = new songDB($conn);
    $songs = $gateway->getAll();
    
    if (isset($_GET['form'])){
        if ($_GET['form']=="title"){
        $result=$gateway->search($_GET['title'],"title");
        }    
        else if ($_GET['form']=="artist_name"){
        $result=$gateway->search($_GET['artist'],"artist_name");
        }
        else if ($_GET['form']=="genre_name"){
        $result=$gateway->search($_GET['genre'],"genre_name");
        }
        else if ($_GET['form']=="year"){
            if ($_GET['year']=="less"){
            $result=$gateway->searchLess($_GET['max-year'],"year");
            }
            else if ($_GET['year']=="greater"){
            $result=$gateway->searchGreater($_GET['min-year'],"year");
            }
        }       
        else if ($_GET['form']=="popularity"){
            if ($_GET['popularity']=="less"){
                $result=$gateway->searchLess($_GET['max-pop'],"popularity");
            }
            else if ($_GET['popularity']=="more"){
                $result=$gateway->searchGreater($_GET['min-pop'],"popularity");
            }
        }
    }
    
   $pdo = null;
}
catch (PDOException $e) {
   die( $e->getMessage() );
} 

//$_SESSION['favorites']=array();

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
        <h1>Search Results</h1>
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
            if (isset($result) && count($result)>0) {
                foreach( $result as $r ) {
                    echo '<tr>';
                    echo '<td>';
                    echo $r['title'];
                    echo '</td>';
                    echo '<td>';
                    echo $r['artist_name'];
                    echo '</td>';
                    echo '<td>';
                    echo $r['year'];
                    echo '</td>';
                    echo '<td>';
                    echo $r['genre_name'];
                    echo '</td>';
                    echo '<td>';
                    echo '<progress value="'.$r['popularity'].'" max="100"></progress>';
                    echo '</td>';
                    echo '<td>';
                    echo '<form method="get">';
                    echo '<input type="button" onclick="location=\'single-song.php?song_id='.$r['song_id'].'\'" value="View">';
                    echo '<input type="button" onclick="location=\'favorites.php?song_id='.$r['song_id'].'&button=Add+to+Favorites\'" name="button" value="Add to Favorites">';
                    echo '<input type="button" onclick="location=\'results.php?song_id='.$r['song_id'].'\'" value="Show All">';
                    echo '</form>';
                    echo '</td>';
                    echo '<td>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
            else if (! empty($_GET['title'])){
                echo "<p>No results for '".$_GET['title']."' found.</p>";
            }
            else {
                //echo "<p> No results found. </p>";
                
                foreach( $songs as $r ) {
                    echo '<tr>';
                    echo '<td>';
                    echo $r['title'];
                    echo '</td>';
                    echo '<td>';
                    echo $r['artist_name'];
                    echo '</td>';
                    echo '<td>';
                    echo $r['year'];
                    echo '</td>';
                    echo '<td>';
                    echo $r['genre_name'];
                    echo '</td>';
                    echo '<td>';
                    echo '<progress value="'.$r['popularity'].'" max="100"></progress>';
                    echo '</td>';
                    echo '<td>';
                    echo '<form method="get">';
                     echo '<input type="button" onclick="location=\'single-song.php?song_id='.$r['song_id'].'\'" value="View">';
                    echo '<input type="button" onclick="location=\'favorites.php?song_id='.$r['song_id'].'&button=Add+to+Favorites\'" name="button" value="Add to Favorites">';
                    echo '<input type="button" onclick="location=\'results.php?song_id='.$r['song_id'].'\'" value="Show All">';
                    echo '</form>'; 
                }
            }
            ?>
        </table>
        <!--<input type="button" onclick="location='href?song_id=[]'">-->
    </section>

</main>
<footer>
    
    <div class="center">&copy 2021 danvynguyen comp3512</div>
</footer>    

</body>
    
</html>