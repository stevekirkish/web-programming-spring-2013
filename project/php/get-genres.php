<?php
// Create JSON string containing structured version of the whole galleries database
// healdsburggalleries.com php version is 5.3.13, as of Apr. 28, 2013
// This means that JSON_encode is available.

require_once("utils/dataconnector.php");

// Fetch the Genres table to populate Galleries Filter select menu
if ($filt_genres = $mysqli->query("SELECT * from genres order by genre")) {  // Load genre category list into local $genres array
	$filtIndex = 1;
	while ($filt_genre = $filt_genres->fetch_object()) {
//		$filter_array[$filt_genre->idgenres] = $filt_genre;   Array ordered by idgenre
		$filter_array[$filtIndex] = $filt_genre;  // Array kept in alphabetical order 
		$filtIndex += 1;
	}
	$filt_genres->close();  
}; 
$mysqli->close(); 

// JSON.php adds JSON capability for older versions of PHP (like on SRJC server)
// used instead of string json_encode(...) function in newer php's, >= ver. 5.2.0
 require_once('utils/JSON.php');
 $json = new Services_JSON;
 $gallery_genres = $json->encode($filter_array);
// This is the code using json_encode - it works mostly, but drops five of
// the gallery descriptions. From it's manual: "This function only works with UTF-8 encoded data."
// Perhaps these five descriptions have UTF-16 chars that snuck in.
// $gallery_db = json_encode($gal_array, JSON_FORCE_OBJECT);
echo $gallery_genres;	// $gallery_genres is structured into an object and returned to Javascript

// By convention, pure php programs have no closing php tag