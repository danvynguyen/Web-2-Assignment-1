DROP TABLE IF EXISTS favorites;

CREATE TABLE favorites (
   song_id INTEGER PRIMARY KEY, 
   title TEXT, 
   artist_name TEXT,  
   year INTEGER,
   genre_name TEXT,     
   popularity INTEGER
);