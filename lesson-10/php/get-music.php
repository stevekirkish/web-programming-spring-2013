<?php
// Create JSON string containing structured version of the whole music database
require_once("utils/dataconnector.php");

// Nested Queries to fetch Genres first,
// Then within each genre, get all artists, then albums, and lastly tracks
if ($genres = $mysqli->query("SELECT * from genres"))  { 
  while ($genre = $genres->fetch_object()) { 
     $musicarray[$genre->idgenres] = $genre;  
     if ($artists = $mysqli->query("select idartists , artist from artists where genres_idgenres = ".$genre->idgenres)) {
	   while ($artist = $artists->fetch_object())
	   {
		 $musicarray[$genre->idgenres]->artists[$artist->idartists] = $artist;	   
if ($albums = $mysqli->query("select idalbums , album from albums where artists_idartists = ".$artist->idartists)) {
			   while ($album = $albums->fetch_object())
			   {
				 $musicarray[$genre->idgenres]->artists[$artist->idartists]->albums[$album->idalbums] = $album;
				 if ($tracks = $mysqli->query("select * from tracks where albums_idalbums = ".$album->idalbums)) {
					while ($track = $tracks->fetch_object()) {
					  $musicarray[$genre->idgenres]->artists[$artist->idartists]->albums[$album->idalbums]->tracks[$track->idtracks] = $track;								 	 			    }
					$tracks->close();		   
				 }					   
			   }
			   $albums->close();		   
		   }
	    }
	   $artists->close();
     }
  } 
  $genres->close();
  
}; 
$mysqli->close(); 

// JSON.php adds JSON capability to older versions of PHP (like on SRJC server)
// used instead of string json_encode(...) function in newer php's
require_once('utils/JSON.php');
$json = new Services_JSON;
$music = $json->encode($musicarray);
echo $music;

// By convention, pure php programs have no closing php tag