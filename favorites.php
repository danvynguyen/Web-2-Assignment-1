<?php 
//insert php code here
require_once('includes/config.inc.php');

try {
   $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $favorites = getFavorites($pdo);   
   $pdo = null;
}
catch (PDOException $e) {
   die( $e->getMessage() );
} 

function getFavorites($pdo) {
   $sql = "SELECT * FROM favorites";
   $result = $pdo->query($sql);
   return $result->fetchAll(PDO::FETCH_ASSOC); 
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
            </tr>
            <?php
                foreach( $favorites as $f ) {
                    echo '<tr>';
                    echo '<td>';
                    echo $f['title'];
                    echo '</td>';
                    echo '<td>';
                    echo $f['artist_name'];
                    echo '</td>';
                    echo '<td>';
                    echo $f['year'];
                    echo '</td>';
                    echo '<td>';
                    echo $f['genre_name'];
                    echo '</td>';
                    echo '<td>';
                    echo $f['popularity'];
                    echo '</td>';
                    echo '</tr>';
                }
            ?>
        </table>
        
        
        
        
        <button type="button">Remove All</button>
        <button type="button">Remove</button>
        <button type="button">View</button>
    </section>
    
</main>
<footer>
    
    <div>&copy 2021 danvynguyen comp3512</div>
</footer>    

</body>
    
</html>