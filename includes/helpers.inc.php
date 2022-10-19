<?php
// function to find song
function findSongsTest($title,$artist,$less_year,$greater_year,$genre,$less_popular,$more_popular) {  
        $sql = "SELECT song_id, title, artist_name, year, genre_name, popularity FROM artists INNER JOIN songs ON artists.artist_id=songs.artist_id INNER JOIN genres ON genres.genre_id=songs.genre_id"; 
        $sql .= " WHERE title LIKE '%$title%'";
        $sql .= " OR artist_name LIKE '%$artist%'";
        $sql .= " OR year < '%$less_year%'";
        $sql .= " OR year > '%$greater_year%'";
        $sql .= " OR genre_name LIKE '%$genre%'";
        $sql .= " OR year < '%$less_popular%'";
        $sql .= " OR year > '%$more_popular%'"; 
        
        $statement = $pdo->prepare($sql); 
        /*$statement->bindValue(1, '%' . $title . '%');
        $statement->bindValue(1, '%' . $artist . '%');
        $statement->bindValue(1, '%' . $less_year . '%');
        $statement->bindValue(1, '%' . $greater_year . '%');
        $statement->bindValue(1, '%' . $genre . '%');
        $statement->bindValue(1, '%' . $less_popular . '%');    
        $statement->bindValue(1, '%' . $more_popular . '%');*/    
        $statement->execute( array("song_id"=>$song_id,"title"=>$title,"artist"=>$artist,"less_year"=>$less_year,"greater_year"=>$greater_year,"genre"=>$genre,"less_popular"=>$less_popular,"more_popular"=>$more_popular)); 
        return $statement->fetchAll(PDO::FETCH_ASSOC);  
     
} 
      

//function to add song to favorites.
function addSongTest($pdo, $title, $artist_name, $year, $genre_name, $popularity) { 
    $sql = "INSERT INTO favorites (title, artist_name, year, genre_name, popularity) VALUES 
            (:title,:artist_name,:year,:genre_name,:popularity)"; 
    $statement = $pdo->prepare($sql); 
    $statement->execute( array("title"=>$title,"artist_name"=>$artist_name,"year"=>$year,"genre_name"=>$genre_name,"popularity"=>$popularity));
} 

?>