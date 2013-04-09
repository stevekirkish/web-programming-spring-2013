<?php
require_once("utils/dataconnector.php");
if ($_POST["album"]) {
	$newalbum = $mysqli->prepare("insert into albums (artists_idartists, album, release_year, img_file) values (?,?,?,?)");
	$newalbum->bind_param("isis",$_POST['artistId'], $_POST['album'], $_POST['releaseYear'], $_POST['albumImg']);
	$newalbum->execute();
	print_r($mysqli->error);
 	$albumid = $newalbum->insert_id;
  	echo $albumid;
	$newalbum->close();
}
$mysqli->close();