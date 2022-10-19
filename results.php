<?php 
require_once('includes/config.inc.php');
require_once('includes/helpers.inc.php');

try {
   $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //insert code here.
   
   if (isset($_POST["title"]) && isset($_POST["artist"]) && isset($_POST["less_year"]) && isset($_POST["greater_year"]) && isset($_POST["genre"]) && isset($_POST["less_popular"]) && isset($_POST["more popular"])){
       //$results=findSongs($_POST["title"],$_POST["artist"],$_POST["less_year"],$_POST["greater_year"],$_POST["genre"],$_POST["less_popular"],$_POST["more_popular"]);
       $results=findSongs();
       
   } 
   $pdo = null;
}
catch (PDOException $e) {
   die( $e->getMessage() );
} 

// function to find song
/*function findSongs($title,$artist,$less_year,$greater_year,$genre,$less_popular,$more_popular) {  
        $sql = "SELECT song_id, title, artist_name, year, genre_name, popularity FROM artists INNER JOIN songs ON artists.artist_id=songs.artist_id INNER JOIN genres ON genres.genre_id=songs.genre_id"; 
        $sql .= " WHERE title LIKE '%$title%'";
        $sql .= " OR artist_name LIKE '%$artist%'";
        $sql .= " OR year < '%$less_year%'";
        $sql .= " OR year > '%$greater_year%'";
        $sql .= " OR genre_name LIKE '%$genre%'";
        $sql .= " OR year < '%$less_popular%'";
        $sql .= " OR year > '%$more_popular%'"; 
        
        $statement = $pdo->prepare($sql);    
        $statement->execute( array("song_id"=>$song_id,"title"=>$title,"artist"=>$artist,"less_year"=>$less_year,"greater_year"=>$greater_year,"genre"=>$genre,"less_popular"=>$less_popular,"more_popular"=>$more_popular)); 
        return $statement->fetchAll();  
     
}*/

function findSongs() {  
        $sql = "SELECT song_id, title, artist_name, year, genre_name, popularity FROM artists INNER JOIN songs ON artists.artist_id=songs.artist_id INNER JOIN genres ON genres.genre_id=songs.genre_id"; 
        $sql .= " WHERE title LIKE '".$_POST["title"]."'";
        $sql .= " OR artist_name LIKE '".$_POST["artist"]."'";
        $sql .= " OR year < '".$_POST["less_year"]."'";
        $sql .= " OR year > '".$_POST["greater_year"]."'";
        $sql .= " OR genre_name LIKE '".$_POST["genre"]."'";
        $sql .= " OR year < '".$_POST["less_popular"]."'";
        $sql .= " OR year > '".$_POST["more_popular"]."'"; 
        $result=$pdo->query($sql);
        return $result->fetchAll();
     
}

//function to add song to favorites.
function addSong($pdo, $title, $artist_name, $year, $genre_name, $popularity) { 
    $sql = "INSERT INTO favorites (title, artist_name, year, genre_name, popularity) VALUES 
            (:title,:artist_name,:year,:genre_name,:popularity)"; 
    $statement = $pdo->prepare($sql); 
    $statement->execute( array("title"=>$title,"artist_name"=>$artist_name,"year"=>$year,"genre_name"=>$genre_name,"popularity"=>$popularity));
} 

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
            </tr>"
            <?php
            if (isset($results) && count($results)>0) {
                foreach( $results as $r ) {
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
                    echo $r['popularity'];
                    echo '</td>';
                    echo '</tr>';
                }
            }
            else {
                echo "<p>No results for '".$_POST["title"]."' found.</p>";
            }
                
            ?>
        </table>
        
        <form action="favorites.php" method="post">
        <button type="button">Show All</button>
        <input type="submit" value="Add to Favorites" />
        <!--<button type="button"><a href='"single-song.php?song_id='.$POST["song_id"].'"'>View</a></button>-->
        </form>
        
    </section>


</main>
<footer>
    
    <div>&copy 2021 danvynguyen comp3512</div>
</footer>    

</body>
    
</html>