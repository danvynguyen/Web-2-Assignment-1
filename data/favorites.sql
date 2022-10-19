DROP TABLE IF EXISTS favorites;

CREATE TABLE favorites (
   song_id INTEGER PRIMARY KEY, 
   title TEXT, 
   artist_name TEXT,  
   year INTEGER,
   genre_name TEXT,     
   popularity INTEGER
);

INSERT INTO favorites (song_id, title, artist_name, year, genre_name, popularity) VALUES (1000, 'Never Gonna Give You Up', 'Rick Astley', 1987, 'pop', 100);