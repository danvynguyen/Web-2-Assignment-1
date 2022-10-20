<?php
// function to find song
//function findSongsTest($title,$artist,$less_year,$greater_year,$genre,$less_popular,$more_popular) {  
/*        $sql = "SELECT song_id, title, artist_name, year, genre_name, popularity FROM artists INNER JOIN songs ON artists.artist_id=songs.artist_id INNER JOIN genres ON genres.genre_id=songs.genre_id"; 
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
        $statement->bindValue(1, '%' . $more_popular . '%');    
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
function findSongs() {  
        $sql = "SELECT song_id, title, artist_name, year, genre_name, popularity FROM artists INNER JOIN songs ON artists.artist_id=songs.artist_id INNER JOIN genres ON genres.genre_id=songs.genre_id"; 
        $sql .= " WHERE title LIKE '".$_POST["title"]."'";
        $sql .= " OR artist_name LIKE '".$_POST["artist"]."'";
        $sql .= " OR year < '".$_POST["less_year"]."'";
        $sql .= " OR year > '".$_POST["greater_year"]."'";
        $sql .= " OR genre_name LIKE '".$_POST["genre"]."'";
        $sql .= " OR year < '".$_POST["less_popular"]."'";
        $sql .= " OR y
        ear > '".$_POST["more_popular"]."'"; 
        $result=$pdo->query($sql);
        return $result->fetchAll();
     
}

//function 

//function to add song to favorites.
function addSongToFavorites($pdo, $title, $artist_name, $year, $genre_name, $popularity) { 
        $sql = "INSERT INTO favorites (title, artist_name, year, genre_name, popularity) VALUES 
            (:title,:artist_name,:year,:genre_name,:popularity)"; 
        $statement = $pdo->prepare($sql); 
        $statement->execute( array("title"=>$title,"artist_name"=>$artist_name,"year"=>$year,"genre_name"=>$genre_name,"popularity"=>$popularity));
    }     
 

*/
//require_once('includes/config.inc.php');
 
class DatabaseHelper { 
    /* Returns a connection object to a database */
    public static function createConnection( $values=array() ) { 
        $connString = $values[0]; 
        $user = $values[1]; 
        $password = $values[2]; 
        $pdo = new PDO($connString,$user,$password); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, 
                PDO::ERRMODE_EXCEPTION); 
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, 
                PDO::FETCH_ASSOC); 
        return $pdo; 
} 
 /*
 Runs the specified SQL query using the passed connection and 
 the passed array of parameters (null if none)
 */
public static function runQuery($connection, $sql, $parameters) { 
    $statement = null; 
    // if there are parameters then do a prepared statement
    if (isset($parameters)) { 
        // Ensure parameters are in an array
        if (!is_array($parameters)) { 
            $parameters = array($parameters); 
        } 
        // Use a prepared statement if parameters 
        $statement = $connection->prepare($sql); 
        $executedOk = $statement->execute($parameters); 
        if (! $executedOk) throw new PDOException; 
        } else { 
        // Execute a normal query 
        $statement = $connection->query($sql); 
        if (!$statement) throw new PDOException; 
        } 
        return $statement; 
    } 
}

class somethingStupid {
    private static $baseSQL = "SELECT * FROM songs NATURAL JOIN artists NATURAL JOIN genres INNER JOIN Types ON artists.artist_type_id = types.type_id ";

    public function __construct($connection) {
        $this->pdo = $connection;
    }

    public function callArtist() {
        $sql = "SELECT artist_name FROM artists";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
    
    public function callGenre() {
        $sql = "SELECT genre_name FROM genres";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getAll() { 
        $sql = self::$baseSQL; 
        $statement = 
            DatabaseHelper::runQuery($this->pdo, $sql, null); 
        return $statement->fetchAll(); 
    }
    
     public function search($find, $column) { 
        $sql = self::$baseSQL."WHERE ".$column."=?"; 
        $statement = 
            DatabaseHelper::runQuery($this->pdo, $sql, array($find)); 
        return $statement->fetchAll(); 
    }

    public function searchYear($find, $column) { 
        $sql = self::$baseSQL."WHERE ".$column."<?"; 
        $statement = 
            DatabaseHelper::runQuery($this->pdo, $sql, array($find)); 
        return $statement->fetchAll(); 
    }
}

?>