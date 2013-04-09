<?php
require_once("utils/dataconnector.php");
if ($_POST["track"]) {
	$newtrack = $mysqli->prepare("insert into tracks (albums_idalbums, track, track_num) values (?,?,?)");
	$newtrack->bind_param("isi",$_POST['albumid'], $_POST['track'], $_POST['track_num']);
	$newtrack->execute();
	print_r($mysqli->error);
 	$trackid = $newtrack->insert_id;
  	echo $trackid;
	$newtrack->close();
}
$mysqli->close();