<?php 
require_once('includes/config.inc.php');
require_once('includes/helpers.inc.php');

session_start();

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $gateway = new somethingStupid($conn);
    
    if (isset($_POST['form'])){
        if ($_POST['form']=="title"){
        $result=$gateway->search($_POST['title'],"title");
        }    
        else if ($_POST['form']=="artist_name"){
        $result=$gateway->search($_POST['artist'],"artist_name");
        }
        else if ($_POST['form']=="genre_name"){
        $result=$gateway->search($_POST['genre'],"genre_name");
        }
        else if ($_POST['form']=="year"){
            if ($_POST['year']=="less"){
            $result=$gateway->searchLess($_POST['year'],"year");
        }
        else if ($_POST['year']=="greater"){
            $result=$gateway->searchGreater($_POST['year'],"year");
            }
        }       
        else if ($_POST['form']=="popularity"){
            if ($_POST['popularity']=="less"){
                $result=$gateway->searchLess($_POST['popularity'],"popularity");
            }
            else if ($_POST['popularity']=="more"){
                $result=$gateway->searchGreater($_POST['popularity'],"popularity");
            }
        }
    }
    if (isset($_POST['title'])){
        $song_id=$gateway->findSongID($_POST['title']);
    }
    
   $pdo = null;
}
catch (PDOException $e) {
   die( $e->getMessage() );
} 

$_SESSION['favorites']=array();

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
    <nav class="center">
        <a href="home.php">Home</a> |
        <a href="search.php">Search</a> |
        <a href="favorites.php">Favorites</a> |
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
                    foreach ($song_id as $id){
                        //echo '<button type="button"><a href="single-song.php?song_id='.$id['song_id'].'">View</a></button>';
                        echo $id['song_id'];
                    }
                    echo '</td>';
                    echo '<td>';
                    echo '<button type="button"><a href="favorites.php?song_id=">Add to Favorites</a></button>';
                    array_push($_SESSION['favorites'],array("title"=>$r['title'],"artist_name"=>$r['artist_name'],"year"=>$r['year'],"genre_name"=>$r['genre_name'],"popularity"=>$r['popularity']));
                    echo '</td>';
                    echo '</tr>';
                }
            }
            else if (! empty($_POST['title'])){
                echo "<p>No results for '".$_POST['title']."' found.</p>";
            }
            else {
                echo "<p> No results found. </p>";
            }
                
            ?>
        </table>
        
        <!--<form action="favorites.php" method="post">
        <button type="button">Show All</button>
        <input type="submit" value="Add to Favorites" />
        <?php 
        //echo '<button type="button"><a href="single-song.php?song_id='.$_POST['song_id'].'>View</a></button>';
        ?>
        </form>-->
        
    </section>


</main>
<footer>
    
    <div>&copy 2021 danvynguyen comp3512</div>
</footer>    

</body>
    
</html>