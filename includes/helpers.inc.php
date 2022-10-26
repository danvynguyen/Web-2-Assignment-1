<?php

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

class songDB {
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

    public function searchLess(int $find, $column) { 
        $sql = self::$baseSQL."WHERE ".$column."<? ORDER BY year DESC"; 
        $statement = 
            DatabaseHelper::runQuery($this->pdo, $sql, array($find)); 
        return $statement->fetchAll(); 
    }
    public function searchGreater(int $find, $column) { 
        $sql = self::$baseSQL."WHERE ".$column.">? ORDER BY year DESC"; 
        $statement = 
            DatabaseHelper::runQuery($this->pdo, $sql, array($find)); 
        return $statement->fetchAll(); 
    }
    
    public function findSongID($title) {
        $sql = "SELECT song_id FROM songs WHERE title==?";
        $statement = 
            DatabaseHelper::runQuery($this->pdo, $sql, array($title)); 
        return $statement->fetchAll(); 
    }
    
}

function addToFavorites($array) {
    array_push($array,array("title"=>$r['title'],"artist_name"=>$r['artist_name'],"year"=>$r['year'],"genre_name"=>$r['genre_name'],"popularity"=>$r['popularity']));
    
    echo 'Song added to Favorites!';
}

?>